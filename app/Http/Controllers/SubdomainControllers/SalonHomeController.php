<?php

namespace App\Http\Controllers\SubdomainControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonHomeController extends Controller
{
    public function index(Request $request)
    {
      
        // Get salon from middleware (CheckSalonStatus)
        // Middleware has already loaded all necessary relationships and shared with views
        $salon = $request->input('currentSalon');
        $currentSalon = $salon; // For layout compatibility
        
        // Use the main salon show page design for subdomain root
        return view('pages.salons.show', compact('salon', 'currentSalon'));
    }
}
