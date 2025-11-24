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

        // Get salon data
        $salon = $provider->salon;

        return view('provider.dashboard', compact(
            'provider',
            'salon',
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

        $salon = $provider->salon;
        $stats = [
            'pending_appointments' => $provider->appointments()->where('status', 'pending')->count(),
        ];

        return view('provider.bookings.index', compact('provider', 'salon', 'stats', 'appointments'));
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

        $walletEntries = $provider->walletEntries()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Monthly trend
        $monthlyTrend = $provider->walletEntries()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_provider_amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        return view('provider.wallet.index', compact('summary', 'walletEntries', 'monthlyTrend'));
    }

    public function reviews()
    {
        $provider = auth()->user()->provider;

        $reviews = $provider->reviews()
            ->with(['user', 'appointment.service'])
            ->latest()
            ->paginate(15);

        $salon = $provider->salon;
        $stats = [
            'pending_appointments' => $provider->appointments()->where('status', 'pending')->count(),
        ];

        return view('provider.reviews.index', compact('provider', 'salon', 'stats', 'reviews'));
    }

    public function profile()
    {
        $provider = auth()->user()->provider;
        $salon = $provider->salon;
        $stats = [
            'pending_appointments' => $provider->appointments()->where('status', 'pending')->count(),
        ];

        return view('provider.profile', compact('provider', 'salon', 'stats'));
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
        $provider = auth()->user()->provider;
        $salon = $provider->salon;
        $stats = [
            'pending_appointments' => $provider->appointments()->where('status', 'pending')->count(),
        ];

        return view('provider.settings', compact('provider', 'salon', 'stats'));
    }

    public function updateSettings(Request $request)
    {
        $provider = auth()->user()->provider;

        $request->validate([
            'schedule' => 'required|array',
            'schedule.*.weekday' => 'required|integer|between:0,6',
            'schedule.*.enabled' => 'nullable|boolean',
            'schedule.*.start_time' => 'required_if:schedule.*.enabled,1|date_format:H:i',
            'schedule.*.end_time' => 'required_if:schedule.*.enabled,1|date_format:H:i|after:schedule.*.start_time',
            'has_break' => 'nullable|boolean',
            'break_start' => 'nullable|required_if:has_break,1|date_format:H:i',
            'break_end' => 'nullable|required_if:has_break,1|date_format:H:i|after:break_start',
        ]);

        // Update break times
        $provider->update([
            'break_start' => $request->has_break ? $request->break_start : null,
            'break_end' => $request->has_break ? $request->break_end : null,
        ]);

        // Update schedules for each day
        foreach ($request->schedule as $scheduleData) {
            $weekday = $scheduleData['weekday'];
            $enabled = isset($scheduleData['enabled']) && $scheduleData['enabled'];
            
            $provider->schedules()->updateOrCreate(
                ['weekday' => $weekday],
                [
                    'start_time' => $enabled ? $scheduleData['start_time'] : '09:00',
                    'end_time' => $enabled ? $scheduleData['end_time'] : '18:00',
                    'is_off' => !$enabled,
                ]
            );
        }

        return back()->with('success', 'Schedule settings updated successfully!');
    }
    
    public function updateSocial(Request $request)
    {
        $provider = auth()->user()->provider;

        $request->validate([
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'website' => 'nullable|url',
        ]);

        $provider->update($request->only(['facebook', 'instagram', 'twitter', 'youtube', 'linkedin', 'website']));

        return back()->with('success', 'Social media links updated successfully!');
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
