@extends('layouts.app')

@section('title', $provider->name)

@section('content')
<div class="bg-white">
    <!-- Provider Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    @if($provider->photo)
                        <img src="{{ asset('storage/' . $provider->photo) }}" 
                             alt="{{ $provider->name }}" 
                             class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-40 h-40 rounded-full bg-white flex items-center justify-center text-4xl font-bold text-indigo-600 shadow-xl">
                            {{ substr($provider->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Provider Info -->
                <div class="text-center md:text-left text-white flex-1">
                    <h1 class="text-4xl font-bold mb-2">{{ $provider->name }}</h1>
                    <p class="text-xl mb-4 opacity-90">{{ $provider->expertise }}</p>
                    
                    <div class="flex items-center justify-center md:justify-start gap-4 mb-4">
                        <div class="flex items-center">
                            <x-rating-stars :rating="$provider->average_rating" size="md" />
                            <span class="ml-2 text-lg">{{ number_format($provider->average_rating, 1) }}</span>
                            <span class="ml-1 opacity-75">({{ $provider->total_reviews }} reviews)</span>
                        </div>
                    </div>

                    <p class="text-lg opacity-90 mb-4">{{ $provider->salon->name }} - {{ $provider->salon->city }}, {{ $provider->salon->state }}</p>
                    
                    @auth
                        <a href="{{ route('appointments.book', $provider) }}" 
                           class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                            Book Appointment
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                            Login to Book
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- About -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">About</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $provider->bio }}</p>
                </div>

                <!-- Services -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Services Offered</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($provider->services as $service)
                            <x-service-card :service="$service" />
                        @endforeach
                    </div>
                </div>

                <!-- Reviews -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">
                        Reviews ({{ $provider->reviews->count() }})
                    </h2>
                    
                    @if($provider->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($provider->reviews as $review)
                                <x-review-item :review="$review" />
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center">
                            <p class="text-gray-600">No reviews yet. Be the first to leave a review!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Card -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Contact Details</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900">Email</h4>
                                <p class="text-gray-600">{{ $provider->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900">Phone</h4>
                                <p class="text-gray-600">{{ $provider->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- Availability -->
                    <h4 class="font-medium text-gray-900 mb-3">Availability</h4>
                    <div class="space-y-2 text-sm">
                        @if($provider->is_active)
                            <div class="flex items-center text-green-600">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Currently Available
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Currently Unavailable
                            </div>
                        @endif

                        @if($provider->break_start && $provider->break_end)
                            <p class="text-gray-600 mt-2">
                                <span class="font-medium">Break Time:</span><br>
                                {{ \Carbon\Carbon::parse($provider->break_start)->format('g:i A') }} - 
                                {{ \Carbon\Carbon::parse($provider->break_end)->format('g:i A') }}
                            </p>
                        @endif
                    </div>

                    <hr class="my-6">

                    <!-- Salon Info -->
                    <h4 class="font-medium text-gray-900 mb-3">Salon Location</h4>
                    <a href="{{ route('salons.show', $provider->salon) }}" 
                       class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-500 transition duration-200">
                        <h5 class="font-semibold text-indigo-600 mb-1">{{ $provider->salon->name }}</h5>
                        <p class="text-sm text-gray-600">{{ $provider->salon->address }}</p>
                        <p class="text-sm text-gray-600">{{ $provider->salon->city }}, {{ $provider->salon->state }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
