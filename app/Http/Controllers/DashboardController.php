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
        
        $appointments = $user->appointments()
            ->with(['salon', 'provider', 'service', 'payment'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        
        $upcomingAppointments = $user->appointments()
            ->where('appointment_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->with(['salon', 'provider', 'service'])
            ->orderBy('appointment_date')
            ->get();
        
        $pastAppointments = $user->appointments()
            ->where('appointment_date', '<', now())
            ->where('status', 'completed')
            ->with(['salon', 'provider', 'service', 'review'])
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();
        
        return view('pages.dashboard.index', compact('appointments', 'upcomingAppointments', 'pastAppointments'));
    }

    public function bookingPage(Provider $provider)
    {
        $provider->load(['services', 'salon']);
        return view('pages.appointments.book', compact('provider'));
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
