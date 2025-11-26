<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    /**
     * Get salon statistics
     */
    public function statistics()
    {
        $salon = auth()->user()->salon;

        if (!$salon) {
            return response()->json(['message' => 'Salon not found'], 404);
        }

        $stats = [
            'total_providers' => $salon->providers()->count(),
            'active_providers' => $salon->providers()->where('is_active', true)->count(),
            'total_appointments' => $salon->appointments()->count(),
            'today_appointments' => $salon->appointments()->whereDate('appointment_date', today())->count(),
            'pending_appointments' => $salon->appointments()->where('status', 'pending')->count(),
            'confirmed_appointments' => $salon->appointments()->where('status', 'confirmed')->count(),
            'completed_appointments' => $salon->appointments()->where('status', 'completed')->count(),
            'monthly_earnings' => $this->walletService->getSalonEarningsSummary($salon->id, 'month'),
        ];

        return response()->json([
            'success' => true,
            'statistics' => $stats,
        ]);
    }

    /**
     * Get salon providers
     */
    public function providers()
    {
        $salon = auth()->user()->salon;

        if (!$salon) {
            return response()->json(['message' => 'Salon not found'], 404);
        }

        $providers = $salon->providers()
            ->with(['user', 'services'])
            ->withCount([
                'appointments as total_appointments',
                'appointments as completed_appointments' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->get();

        return response()->json([
            'success' => true,
            'providers' => $providers,
        ]);
    }

    /**
     * Get salon appointments
     */
    public function appointments(Request $request)
    {
        $salon = auth()->user()->salon;

        if (!$salon) {
            return response()->json(['message' => 'Salon not found'], 404);
        }

        $query = $salon->appointments()
            ->with(['user', 'provider.user', 'service', 'payment']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->latest('appointment_date')->paginate(20);

        return response()->json([
            'success' => true,
            'appointments' => $appointments,
        ]);
    }

    /**
     * Get salon earnings
     */
    public function earnings(Request $request)
    {
        $salon = auth()->user()->salon;

        if (!$salon) {
            return response()->json(['message' => 'Salon not found'], 404);
        }

        $period = $request->get('period', 'month');
        $summary = $this->walletService->getSalonEarningsSummary($salon->id, $period);

        return response()->json([
            'success' => true,
            'earnings' => $summary,
        ]);
    }

    /**
     * Check slug availability
     */
    public function checkSlugAvailability(Request $request)
    {
        $slug = $request->input('slug');
        $salonId = $request->input('salon_id');

        // Check if slug exists, excluding the current salon if editing
        $query = \App\Models\Salon::where('slug', $slug);
        
        if ($salonId) {
            $query->where('id', '!=', $salonId);
        }
        
        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'slug' => $slug,
            'message' => $exists ? 'This slug is already taken' : 'This slug is available'
        ]);
    }
}
