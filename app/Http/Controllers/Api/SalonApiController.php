<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\Request;

class SalonApiController extends Controller
{
    /**
     * Display a listing of salons
     */
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
        
        $salons = $query->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $salons,
        ]);
    }

    /**
     * Display the specified salon with providers
     */
    public function show(string $id)
    {
        $salon = Salon::with(['providers.services'])
            ->withCount('providers')
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $salon,
        ]);
    }
    
    /**
     * Get providers for a specific salon
     */
    public function providers(string $id)
    {
        $salon = Salon::findOrFail($id);
        $providers = $salon->providers()
            ->where('is_active', true)
            ->with('services')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $providers,
        ]);
    }
}
