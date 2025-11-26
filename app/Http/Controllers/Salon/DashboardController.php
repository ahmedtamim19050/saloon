<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Provider;
use App\Models\ProviderWalletEntry;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    public function index()
    {
        $salon = auth()->user()->salon;

        if (!$salon) {
            abort(403, 'You are not associated with any salon.');
        }

        // Get statistics
        $monthCompletedCount = $salon->appointments()
            ->where('status', 'completed')
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->whereYear('appointment_date', Carbon::now()->year)
            ->count();

        $lastMonthCompletedCount = $salon->appointments()
            ->where('status', 'completed')
            ->whereMonth('appointment_date', Carbon::now()->subMonth()->month)
            ->whereYear('appointment_date', Carbon::now()->subMonth()->year)
            ->count();

        $growthRate = $lastMonthCompletedCount > 0
            ? (($monthCompletedCount - $lastMonthCompletedCount) / $lastMonthCompletedCount) * 100
            : 0;

        $stats = [
            'total_providers' => $salon->providers()->count(),
            'active_providers' => $salon->providers()->where('is_active', true)->count(),
            'today_appointments' => $salon->appointments()
                ->whereDate('appointment_date', today())
                ->count(),
            'pending_appointments' => $salon->appointments()
                ->where('status', 'pending')
                ->count(),
            'confirmed_appointments' => $salon->appointments()
                ->where('status', 'confirmed')
                ->count(),
            'completed_today' => $salon->appointments()
                ->whereDate('appointment_date', today())
                ->where('status', 'completed')
                ->count(),
            'month_completed' => $monthCompletedCount,
            'revenue_target' => 100000, // Can be stored in salon settings
            'booking_target' => 200, // Can be stored in salon settings
            'avg_rating' => $salon->providers()->avg('average_rating') ?? 0,
            'total_reviews' => $salon->providers()->sum('total_reviews') ?? 0,
            'growth_rate' => $growthRate,
        ];

        // Monthly revenue
        $monthlyRevenue = $this->walletService->getSalonEarningsSummary($salon->id);

        // Recent appointments
        $recentAppointments = $salon->appointments()
            ->with(['user', 'provider.user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        // Top performing providers
        $topProviders = $salon->providers()
            ->withCount(['appointments as completed_count' => function ($query) {
                $query->where('status', 'completed')
                    ->whereMonth('appointment_date', Carbon::now()->month);
            }])
            ->with('user')
            ->withAvg('reviews as average_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->orderByDesc('completed_count')
            ->take(5)
            ->get();

        // Due payments (pending and confirmed appointments)
        $dueAppointments = $salon->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['user', 'provider.user', 'service'])
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        // Weekly earnings chart data
        $weeklyEarnings = $this->getWeeklyEarnings($salon->id);

        return view('salon.dashboard', compact(
            'salon',
            'stats',
            'monthlyRevenue',
            'recentAppointments',
            'topProviders',
            'dueAppointments',
            'weeklyEarnings'
        ));
    }

    public function providers()
    {
        $salon = auth()->user()->salon;

        $providers = $salon->providers()
            ->with(['user', 'services'])
            ->withCount([
                'appointments as total_appointments',
                'appointments as completed_appointments' => function ($query) {
                    $query->where('status', 'completed');
                },
                'reviews'
            ])
            ->withSum('walletEntries', 'total_provider_amount')
            ->paginate(15);

        return view('salon.providers.index', compact('salon', 'providers'));
    }

    public function createProvider()
    {
        $salon = auth()->user()->salon;
        return view('salon.providers.create', compact('salon'));
    }

    public function storeProvider(Request $request)
    {
        $salon = auth()->user()->salon;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:providers,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'expertise' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Create user account

            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => 3, // Assuming 3 is the role ID for providers
                'salon_id' => $salon->id,
            ]);
            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('providers/photos', 'public');
            }

            // Create provider
            $provider = Provider::create([
                'user_id' => $user->id,
                'salon_id' => $salon->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'commission_percentage' => $validated['commission_percentage'],
                'expertise' => $validated['expertise'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'photo' => $photoPath,
                'is_active' => $validated['is_active'] ?? true,
                'average_rating' => 0,
                'total_reviews' => 0,
                'wallet_balance' => 0,
            ]);

            DB::commit();

            return redirect()->route('salon.providers')->with('success', 'Provider created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create provider: ' . $e->getMessage());
        }
    }

    public function bookings(Request $request)
    {
        $salon = auth()->user()->salon;

        $query = $salon->appointments()
            ->with(['user', 'provider.user', 'service', 'payment']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->latest('appointment_date')->paginate(20);

        $providers = $salon->providers()->with('user')->get();

        return view('salon.bookings.index', compact('salon', 'appointments', 'providers'));
    }

    public function earnings(Request $request)
    {
        $salon = auth()->user()->salon;

        $period = $request->get('period', 'month');

        // Get earnings summary
        $summary = $this->walletService->getSalonEarningsSummary($salon->id, $period);

        // Get wallet entries with details
        $query = ProviderWalletEntry::whereHas('appointment', function ($q) use ($salon) {
            $q->where('salon_id', $salon->id);
        })->with(['appointment.provider.user', 'appointment.customer', 'appointment.service']);

        // Apply date filter based on period
        switch ($period) {
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        $walletEntries = $query->latest()->paginate(20);

        // Chart data by provider
        $providerEarnings = ProviderWalletEntry::whereHas('appointment', function ($q) use ($salon, $period) {
            $q->where('salon_id', $salon->id);

            if ($period === 'month') {
                $q->whereMonth('appointment_date', Carbon::now()->month)
                    ->whereYear('appointment_date', Carbon::now()->year);
            }
        })
            ->with('appointment.provider.user')
            ->selectRaw('appointment_id, SUM(salon_amount) as total_salon_amount, SUM(provider_amount) as total_provider_amount')
            ->groupBy('appointment_id')
            ->get()
            ->groupBy('appointment.provider.user.name')
            ->map(function ($entries) {
                return [
                    'salon_amount' => $entries->sum('total_salon_amount'),
                    'provider_amount' => $entries->sum('total_provider_amount'),
                ];
            });

        return view('salon.earnings.index', compact('salon', 'summary', 'walletEntries', 'period', 'providerEarnings'));
    }

    public function providerView(Provider $provider)
    {
        $salon = auth()->user()->salon;

        // Check if provider belongs to this salon
        if ($provider->salon_id !== $salon->id) {
            abort(403, 'This provider does not belong to your salon.');
        }

        // Provider earnings
        $earningsSummary = $this->walletService->getProviderEarningsSummary($provider);

        // Monthly earnings (this month)
        $monthlyEarnings = $provider->walletEntries()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_provider_amount');

        // Due amounts (pending/confirmed appointments)
        $dueAmount = $provider->appointments()
            ->whereIn('status', ['confirmed'])
            ->where('payment_status', '!=', 'paid')
            ->sum('total_price');

        // Recent appointments
        $recentAppointments = $provider->appointments()
            ->with(['user', 'service', 'payment'])
            ->latest('appointment_date')
            ->take(10)
            ->get();

        // Weekly performance
        $weeklyData = $this->getProviderWeeklyEarnings($provider);

        return view('salon.providers.view', compact(
            'salon',
            'provider',
            'earningsSummary',
            'monthlyEarnings',
            'dueAmount',
            'recentAppointments',
            'weeklyData'
        ));
    }

    public function profile()
    {
        $salon = auth()->user()->salon;
        return view('salon.profile', compact('salon'));
    }

    public function updateProfile(Request $request)
    {
        $salon = auth()->user()->salon;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:50|regex:/^[a-z0-9-]+$/|unique:salons,slug,' . $salon->id,
            'description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($salon->logo && Storage::disk('public')->exists($salon->logo)) {
                Storage::disk('public')->delete($salon->logo);
            }

            $logoPath = $request->file('logo')->store('salons/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($salon->cover_image && Storage::disk('public')->exists($salon->cover_image)) {
                Storage::disk('public')->delete($salon->cover_image);
            }

            $coverPath = $request->file('cover_image')->store('salons/covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        // Convert keywords and tags from comma-separated strings to arrays
        if (isset($validated['keywords'])) {
            $validated['keywords'] = array_filter(array_map('trim', explode(',', $validated['keywords'])));
        }

        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        }

        $salon->update($validated);

        return redirect()->route('salon.profile')->with('success', 'Profile updated successfully!');
    }

    public function settings()
    {
        $salon = auth()->user()->salon;
        return view('salon.settings', compact('salon'));
    }

    public function updateSettings(Request $request)
    {
        $salon = auth()->user()->salon;

        $validated = $request->validate([
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'website' => 'nullable|url',
        ]);

        $salon->update($validated);

        return redirect()->route('salon.settings')->with('success', 'Settings updated successfully!');
    }

    protected function getWeeklyEarnings($salonId)
    {
        $days = [];
        $earnings = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');

            $dayEarnings = ProviderWalletEntry::whereHas('appointment', function ($q) use ($salonId, $date) {
                $q->where('salon_id', $salonId)
                    ->whereDate('appointment_date', $date);
            })->sum('salon_amount');

            $earnings[] = round($dayEarnings, 2);
        }

        return [
            'labels' => $days,
            'data' => $earnings,
        ];
    }

    protected function getProviderWeeklyEarnings(Provider $provider)
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
