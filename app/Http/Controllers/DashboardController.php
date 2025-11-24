<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Provider;
use App\Services\AppointmentSlotService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $slotService;

    public function __construct(AppointmentSlotService $slotService)
    {
        $this->middleware('auth');
        $this->slotService = $slotService;
    }
    
    public function index()
    {
        $user = auth()->user();
        
        // Redirect to role-specific dashboard
        if ($user->isAdmin()) {
            return redirect()->route('filament.admin.pages.dashboard');
        } elseif ($user->isSalon()) {
            return redirect()->route('salon.dashboard');
        } elseif ($user->isProvider()) {
            return redirect()->route('provider.dashboard');
        } elseif ($user->isCustomer()) {
            return redirect()->route('customer.dashboard');
        }
        
        // Fallback if no role matched
        abort(403, 'Your account does not have access to any dashboard.');
    }

    public function bookingPage(Provider $provider)
    {
        $provider->load(['services', 'salon']);
        return view('pages.appointments.book', compact('provider'));
    }

    public function availableSlots(Request $request, Provider $provider)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'service_ids' => 'required|string',
        ]);

        $serviceIds = explode(',', $validated['service_ids']);
        $services = \App\Models\Service::whereIn('id', $serviceIds)->get();
        
        if ($services->isEmpty()) {
            return response()->json([
                'success' => false,
                'errors' => ['service_ids' => 'Invalid service IDs']
            ], 422);
        }

        $slots = $this->slotService->getAvailableSlotsForMultipleServices(
            $provider,
            $services,
            $validated['date']
        );

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $validated['date'],
                'slots' => $slots->values()->toArray(),
                'total_duration' => $services->sum('duration'),
            ],
        ]);
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'salon_id' => 'required|exists:salons,id',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        try {
            $provider = Provider::findOrFail($validated['provider_id']);
            $services = \App\Models\Service::whereIn('id', $validated['service_ids'])->get();
            
            $appointment = $this->slotService->bookAppointmentWithMultipleServices(
                $provider,
                auth()->id(),
                $services,
                $validated['appointment_date'],
                $validated['start_time'],
                $request->input('notes')
            );

            // Load relationships for thank you page
            $appointment->load(['provider.user', 'services', 'salon']);

            return redirect()
                ->route('appointments.thank-you')
                ->with('appointment', $appointment);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function thankYou()
    {
        // Check if appointment data exists in session
        if (!session()->has('appointment')) {
            return redirect()->route('dashboard');
        }

        return view('pages.appointments.thank-you');
    }
}
