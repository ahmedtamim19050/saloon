<?php

namespace App\Http\Middleware;

use App\Models\Salon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSalonStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the salon slug from the subdomain
        // URL format: {slug}.saloon.test
        $host = $request->getHost();
        
        // Extract slug from subdomain
        // Example: glamour-beauty-salon-masonhaven.saloon.test → glamour-beauty-salon-masonhaven
        $hostParts = explode('.', $host);
        
        if (count($hostParts) < 3) {
            abort(404, 'Invalid subdomain format');
        }
        
        $salonSlug = $hostParts[0];
        
        // Find the salon by slug
        $salon = Salon::where('slug', $salonSlug)
            ->with(['providers.services', 'providers.user', 'reviews.user', 'reviews.provider.user', 'owner'])
            ->first();
        
        // If salon doesn't exist, show 404
        if (!$salon) {
            abort(404, 'Salon not found: ' . $salonSlug);
        }
        
        // If salon is not active, show maintenance message
        if ($salon->status !== 'active') {
            return response()->view('salon-subdomain.maintenance', [
                'salon' => $salon
            ], 503);
        }
        
        // Share the salon with all views
        view()->share('currentSalon', $salon);
        
        // Also set in request for controller access
        $request->merge(['currentSalon' => $salon]);
        
        return $next($request);
    }
}
