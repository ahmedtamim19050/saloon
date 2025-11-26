<?php

namespace App\Http\Controllers\SubdomainControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonContactController extends Controller
{
    public function index()
    {
        return view('salon-subdomain.contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Here you can send email or save to database
        // For now, just return success message
        
        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
