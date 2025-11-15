<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function show(Provider $provider)
    {
        $provider->load(['salon', 'services', 'reviews.user', 'reviews.appointment.service']);
        
        return view('pages.providers.show', compact('provider'));
    }
}
