<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of providers.
     */
    public function index(Request $request)
    {
        $query = Provider::with(['salon', 'services', 'reviews', 'appointments'])
            ->where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('expertise', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%")
                    ->orWhereHas('salon', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $providers = $query->orderByDesc('average_rating')
            ->orderByDesc('total_reviews')
            ->paginate(12);

        return view('pages.providers.index', compact('providers'));
    }

    /**
     * Display the specified provider.
     */
    public function show(Request $request, ...$params)
    {
        // Check if this is a subdomain request
        $isSubdomain = $request->has('currentSalon');
        
        // In subdomain routes: $params[0] = salon slug, $params[1] = provider ID
        // In regular routes: $params[0] = provider (Model or ID)
        $providerId = $isSubdomain ? ($params[1] ?? null) : ($params[0] ?? null);
        
        if (!$providerId) {
            abort(404, 'Provider not found');
        }
        
        // If provider is already a Model instance, use it
        if ($providerId instanceof Provider) {
            $provider = $providerId;
        } else {
            // Otherwise, find by ID
            if ($isSubdomain) {
                // For subdomain, ensure provider belongs to current salon
                $salon = $request->input('currentSalon');
                $provider = Provider::where('id', $providerId)
                    ->where('salon_id', $salon->id)
                    ->firstOrFail();
            } else {
                $provider = Provider::findOrFail($providerId);
            }
        }
        
        $provider->load(['salon', 'services', 'reviews.user', 'reviews.appointment.service']);
        
        // If subdomain, use subdomain layout
        if ($isSubdomain) {
            $currentSalon = $request->input('currentSalon');
            return view('pages.providers.show-subdomain', compact('provider', 'currentSalon'));
        }
        
        return view('pages.providers.show', compact('provider'));
    }
}
