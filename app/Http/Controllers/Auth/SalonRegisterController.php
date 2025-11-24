<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Salon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SalonRegisterController extends Controller
{
    /**
     * Display the salon registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.salon-register');
    }

    /**
     * Handle a salon registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'salon_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Salon owner role
        ]);

        // Create salon with minimal required fields
        $salon = Salon::create([
            'owner_id' => $user->id,
            'name' => $request->salon_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => 'To be updated', // Temporary value
            'city' => 'N/A',
            'state' => 'N/A',
            'zip_code' => 'N/A',
            'description' => 'Profile pending completion',
            'is_active' => false, // Will be activated after profile completion and admin approval
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to salon profile/dashboard to complete setup
        return redirect()->route('salon.profile')->with('success', 'Registration successful! Please complete your salon profile.');
    }
}
