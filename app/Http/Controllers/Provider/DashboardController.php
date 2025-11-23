<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    public function index()
    {
        $provider = auth()->user()->provider;

        if (!$provider) {
            abort(403, 'You are not associated with any provider profile.');
        }

        // Monthly statistics
        $monthCompletedCount = $provider->appointments()
            ->where('status', 'completed')
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->whereYear('appointment_date', Carbon::now()->year)
            ->count();

        $lastMonthCompletedCount = $provider->appointments()
            ->where('status', 'completed')
            ->whereMonth('appointment_date', Carbon::now()->subMonth()->month)
            ->whereYear('appointment_date', Carbon::now()->subMonth()->year)
            ->count();

        $growthRate = $lastMonthCompletedCount > 0 
            ? (($monthCompletedCount - $lastMonthCompletedCount) / $lastMonthCompletedCount) * 100 
            : 0;

        // Monthly earnings amount
        $currentMonthEarnings = $provider->walletEntries()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_provider_amount');

        // Statistics
        $stats = [
            'today_appointments' => $provider->appointments()
                ->whereDate('appointment_date', today())
                ->count(),
            'pending_appointments' => $provider->appointments()
                ->where('status', 'pending')
                ->count(),
            'confirmed_appointments' => $provider->appointments()
                ->where('status', 'confirmed')
                ->count(),
            'completed_today' => $provider->appointments()
                ->whereDate('appointment_date', today())
                ->where('status', 'completed')
                ->count(),
            'wallet_balance' => $provider->wallet_balance,
            'total_reviews' => $provider->total_reviews ?? 0,
            'average_rating' => $provider->average_rating ?? 0,
            'month_completed' => $monthCompletedCount,
            'current_month_earnings' => $currentMonthEarnings,
            'earnings_target' => 50000, // Can be stored in provider settings
            'booking_target' => 100, // Can be stored in provider settings
            'growth_rate' => $growthRate,
        ];

        // Monthly earnings summary
        $monthlyEarnings = $this->walletService->getProviderEarningsSummary($provider);

        // Today's appointments
        $todayAppointments = $provider->appointments()
            ->with(['user', 'service'])
            ->whereDate('appointment_date', today())
            ->orderBy('start_time')
            ->get();

        // Upcoming appointments
        $upcomingAppointments = $provider->appointments()
            ->with(['user', 'service'])
            ->where('appointment_date', '>', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Weekly earnings chart
        $weeklyEarnings = $this->getWeeklyEarnings($provider);

        return view('provider.dashboard', compact(
            'provider',
            'stats',
            'monthlyEarnings',
            'todayAppointments',
            'upcomingAppointments',
            'weeklyEarnings'
        ));
    }

    public function bookings(Request $request)
    {
        $provider = auth()->user()->provider;

        $query = $provider->appointments()
            ->with(['user', 'service', 'payment']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->latest('appointment_date')->paginate(20);

        return view('provider.bookings.index', compact('provider', 'appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $provider = auth()->user()->provider;

        // Verify ownership
        if ($appointment->provider_id !== $provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $oldStatus = $appointment->status;

        $appointment->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        // Send notification to customer
        $appointment->customer->notify(
            new \App\Notifications\AppointmentStatusNotification($appointment, $oldStatus, $request->status)
        );

        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function wallet()
    {
        $provider = auth()->user()->provider;

        $summary = $this->walletService->getProviderEarningsSummary($provider);

        $walletEntries = $this->walletService->getProviderWalletEntries($provider)
            ->paginate(20);

        // Monthly trend
        $monthlyTrend = $provider->walletEntries()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_provider_amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        return view('provider.wallet.index', compact('provider', 'summary', 'walletEntries', 'monthlyTrend'));
    }

    public function reviews()
    {
        $provider = auth()->user()->provider;

        $reviews = $provider->reviews()
            ->with(['user', 'appointment.service'])
            ->latest()
            ->paginate(15);

        return view('provider.reviews.index', compact('provider', 'reviews'));
    }

    public function profile()
    {
        return view('provider.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Check current password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function settings()
    {
        return view('provider.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'has_break' => 'nullable|boolean',
            'break_start' => 'nullable|required_if:has_break,1|date_format:H:i',
            'break_end' => 'nullable|required_if:has_break,1|date_format:H:i|after:break_start',
        ]);

        $user->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'working_days' => $request->working_days,
            'has_break' => $request->has_break ?? false,
            'break_start' => $request->has_break ? $request->break_start : null,
            'break_end' => $request->has_break ? $request->break_end : null,
        ]);

        return back()->with('success', 'Availability settings updated successfully!');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $notifications = $request->input('notifications', []);

        $user->update([
            'notifications' => $notifications,
        ]);

        return back()->with('success', 'Notification preferences updated successfully!');
    }

    protected function getWeeklyEarnings($provider)
    {
        $days = [];
        $earnings = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');

            $dayEarnings = $provider->walletEntries()
                ->whereDate('created_at', $date)
                ->sum('total_provider_amount');

            $earnings[] = round($dayEarnings, 2);
        }

        return [
            'labels' => $days,
            'data' => $earnings,
        ];
    }
}
