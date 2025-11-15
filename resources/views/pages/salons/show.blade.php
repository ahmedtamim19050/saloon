@extends('layouts.app')

@section('title', $salon->name)

@section('content')
<div class="bg-white">
    <!-- Hero Section with Salon Image -->
    <div class="relative h-96 bg-gradient-to-r from-indigo-600 to-purple-600">
        @if($salon->image)
            <img src="{{ asset('storage/' . $salon->image) }}" alt="{{ $salon->name }}" 
                 class="w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-4">{{ $salon->name }}</h1>
                <p class="text-xl">{{ $salon->city }}, {{ $salon->state }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">About Us</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $salon->description }}</p>
                </div>

                <!-- Providers -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Team</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($salon->providers as $provider)
                            <x-provider-card :provider="$provider" />
                        @endforeach
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Services Available</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $uniqueServices = $salon->providers->flatMap->services->unique('id');
                        @endphp
                        @foreach($uniqueServices as $service)
                            <x-service-card :service="$service" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Information -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900">Address</h4>
                                <p class="text-gray-600">{{ $salon->address }}</p>
                                <p class="text-gray-600">{{ $salon->city }}, {{ $salon->state }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900">Phone</h4>
                                <p class="text-gray-600">{{ $salon->phone }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900">Email</h4>
                                <p class="text-gray-600">{{ $salon->email }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- Working Hours -->
                    <h4 class="font-medium text-gray-900 mb-3">Working Hours</h4>
                    <div class="space-y-2">
                        @php
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            $workingDays = array_map('strtolower', $salon->working_days ?? []);
                        @endphp
                        @foreach($days as $day)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $day }}</span>
                                @if(in_array(strtolower($day), $workingDays))
                                    <span class="text-green-600 font-medium">
                                        {{ \Carbon\Carbon::parse($salon->opening_time)->format('g:i A') }} - 
                                        {{ \Carbon\Carbon::parse($salon->closing_time)->format('g:i A') }}
                                    </span>
                                @else
                                    <span class="text-red-600 font-medium">Closed</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
