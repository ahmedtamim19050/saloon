<?php

namespace App\Http\Controllers\SubdomainControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonBookingController extends Controller
{
    public function index()
    {
        return view('salon-subdomain.booking');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        // Here you can create appointment
        // For now, just return success message
        
        return redirect()->back()->with('success', 'Your booking request has been received! We will confirm shortly.');
    }
}
