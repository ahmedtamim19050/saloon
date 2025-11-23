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
            'service_id' => 'required|exists:services,id',
        ]);

        $service = \App\Models\Service::findOrFail($validated['service_id']);

        $slots = $this->slotService->getAvailableSlots(
            $provider,
            $service,
            $validated['date']
        );

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $validated['date'],
                'slots' => $slots->values()->toArray(),
            ],
        ]);
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'salon_id' => 'required|exists:salons,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        try {
            $appointment = $this->slotService->bookAppointment(
                auth()->user(),
                $validated['provider_id'],
                $validated['salon_id'],
                $validated['service_id'],
                $validated['appointment_date'],
                $validated['start_time'],
                $request->input('notes')
            );

            return redirect()
                ->route('dashboard')
                ->with('success', 'Appointment booked successfully! We look forward to seeing you.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
