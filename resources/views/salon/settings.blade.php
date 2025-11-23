@extends('layouts.dashboard')

@section('title', 'Salon Settings')
@section('user-role', 'Salon Owner')
@section('header', 'Salon Settings')

@section('sidebar')
<a href="{{ route('salon.dashboard') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>
<a href="{{ route('salon.providers') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Providers
</a>
<a href="{{ route('salon.bookings') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    Bookings
</a>
<a href="{{ route('salon.earnings') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Earnings
</a>
<a href="{{ route('salon.profile') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
    </svg>
    Salon Profile
</a>
<a href="{{ route('salon.settings') }}" class="block px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Settings
</a>
@endsection

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl">
    <!-- Business Hours Settings -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-6 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Business Hours</h3>
            <p class="text-sm text-gray-600 mt-1">Configure your salon's operating hours</p>
        </div>

        <form action="{{ route('salon.settings.update') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Opening Time -->
                <div>
                    <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-2">Opening Time *</label>
                    <input type="time" id="opening_time" name="opening_time" value="{{ old('opening_time', $salon->opening_time ?? '09:00') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('opening_time') border-red-500 @enderror">
                    @error('opening_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Closing Time -->
                <div>
                    <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-2">Closing Time *</label>
                    <input type="time" id="closing_time" name="closing_time" value="{{ old('closing_time', $salon->closing_time ?? '20:00') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('closing_time') border-red-500 @enderror">
                    @error('closing_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Commission Settings -->
            <div class="pt-6 border-t">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Commission Settings</h4>
                
                <div>
                    <label for="commission_percentage" class="block text-sm font-medium text-gray-700 mb-2">Salon Commission Percentage *</label>
                    <div class="relative">
                        <input type="number" id="commission_percentage" name="commission_percentage" 
                            value="{{ old('commission_percentage', $salon->commission_percentage ?? 20) }}" 
                            min="0" max="100" step="0.01" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('commission_percentage') border-red-500 @enderror">
                        <span class="absolute right-4 top-2 text-gray-500">%</span>
                    </div>
                    @error('commission_percentage')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">The percentage of each booking that goes to the salon (remaining goes to provider)</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-4 border-t">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-blue-50 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-semibold text-blue-900">Business Hours</h4>
                    <p class="text-sm text-blue-700 mt-1">These hours will be used to calculate available time slots for appointments.</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-semibold text-green-900">Commission</h4>
                    <p class="text-sm text-green-700 mt-1">The commission rate applies to all providers unless they have individual rates set.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
