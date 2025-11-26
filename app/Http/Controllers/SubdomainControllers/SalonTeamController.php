<?php

namespace App\Http\Controllers\SubdomainControllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class SalonTeamController extends Controller
{
    public function index()
    {
        return view('salon-subdomain.teams');
    }

    public function show(Request $request, $providerId)
    {
        // Get current salon from middleware
        $salon = $request->input('currentSalon');

        
        // Find provider by ID and ensure it belongs to current salon
        $provider = Provider::where('id', $providerId)
            ->where('salon_id', $salon->id)
            ->first();
  dd($providerId);
        // Load provider with services and reviews
        // $provider->load(['services', 'reviews.customer']);
        
        return view('pages.providers.show', compact('provider'));
    }
}
