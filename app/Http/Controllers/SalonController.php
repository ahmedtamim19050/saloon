<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index(Request $request)
    {
        $query = Salon::where('is_active', true)
            ->withCount('providers');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        $salons = $query->paginate(12);
        $cities = Salon::where('is_active', true)
            ->distinct()
            ->pluck('city')
            ->sort();
        
        return view('pages.salons.index', compact('salons', 'cities'));
    }
    
    // Salon detail pages now use subdomain routing
    // See routes/salon.php and SubdomainControllers
}
