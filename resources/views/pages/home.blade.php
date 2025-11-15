@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Find Your Perfect Salon Experience</h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">Book appointments with top beauty professionals in your area</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('salons.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:text-lg">
                    Browse Salons
                </a>
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-indigo-600 md:text-lg">
                        Get Started
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Why Choose Us</h2>
            <p class="mt-4 text-lg text-gray-600">Everything you need for a seamless booking experience</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">📅</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Easy Booking</h3>
                <p class="text-gray-600">Book appointments online in just a few clicks</p>
            </div>
            
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">⭐</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Top Professionals</h3>
                <p class="text-gray-600">Verified reviews and ratings from real customers</p>
            </div>
            
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">💳</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Secure Payments</h3>
                <p class="text-gray-600">Pay after your service with optional tips</p>
            </div>
        </div>
    </div>
</div>

<!-- Top Salons Section -->
@if($salons->count() > 0)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Featured Salons</h2>
            <a href="{{ route('salons.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">View All →</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($salons as $salon)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $salon->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $salon->city }}, {{ $salon->state }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-500 mb-4">{{ $salon->providers_count }} providers available</p>
                        <a href="{{ route('salons.show', $salon) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                            View Salon →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Services Section -->
@if($services->count() > 0)
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Popular Services</h2>
            <p class="mt-4 text-lg text-gray-600">Professional beauty and wellness services</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                @include('components.service-card', ['service' => $service])
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Top Providers Section -->
@if($topProviders->count() > 0)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Top Rated Providers</h2>
            <p class="mt-4 text-lg text-gray-600">Book with our highest-rated professionals</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($topProviders as $provider)
                @include('components.provider-card', ['provider' => $provider])
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- CTA Section -->
<div class="bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-indigo-100 mb-8">Join thousands of satisfied customers</p>
        @guest
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:text-lg">
                Create Free Account
            </a>
        @else
            <a href="{{ route('salons.index') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:text-lg">
                Book an Appointment
            </a>
        @endguest
    </div>
</div>
@endsection
