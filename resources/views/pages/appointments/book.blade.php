@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center">
                <a href="{{ route('providers.show', $provider) }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">Book Appointment</h1>
                    <p class="text-gray-600 mt-1">Schedule your appointment with {{ $provider->name }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <form action="{{ route('appointments.store') }}" method="POST" x-data="bookingForm()">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                        <input type="hidden" name="salon_id" value="{{ $provider->salon_id }}">

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Service Selection -->
                        <div class="mb-6">
                            <label for="service_id" class="block text-sm font-semibold text-gray-900 mb-2">
                                <svg class="inline h-5 w-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Select Service *
                            </label>
                            <select x-model="serviceId" @change="serviceChanged()" id="service_id" name="service_id" required class="block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('service_id') border-red-500 @enderror">
                                <option value="">Choose a service...</option>
                                @foreach($provider->services as $service)
                                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}" data-price="{{ $service->price }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} - ${{ number_format($service->price, 2) }} ({{ $service->duration }} min)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p x-show="selectedService" class="mt-2 text-sm text-gray-600 bg-gray-50 p-3 rounded" x-text="selectedService"></p>
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-6">
                            <label for="appointment_date" class="block text-sm font-semibold text-gray-900 mb-2">
                                <svg class="inline h-5 w-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Select Date *
                            </label>
                            <input x-model="appointmentDate" @change="loadSlots()" type="date" id="appointment_date" name="appointment_date" :min="minDate" value="{{ old('appointment_date') }}" required class="block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('appointment_date') border-red-500 @enderror">
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Loading Indicator -->
                        <div x-show="loading" class="mb-6 text-center py-8 bg-gray-50 rounded-lg">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                            <p class="mt-3 text-sm text-gray-600">Loading available time slots...</p>
                        </div>

                        <!-- Time Slots -->
                        <div x-show="slots.length > 0 && !loading" class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">
                                <svg class="inline h-5 w-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Select Time *
                            </label>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                <template x-for="slot in slots" :key="slot">
                                    <button type="button" @click="selectSlot(slot)" :class="selectedSlot === slot ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-500 hover:bg-indigo-50'" class="px-4 py-3 text-sm font-medium rounded-lg border-2 transition-all duration-150 transform hover:scale-105">
                                        <span x-text="slot"></span>
                                    </button>
                                </template>
                            </div>
                            <input type="hidden" name="start_time" x-model="selectedSlot">
                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Slots Message -->
                        <div x-show="!loading && serviceId && appointmentDate && slots.length === 0" class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-yellow-800">No available time slots</p>
                                    <p class="text-sm text-yellow-700 mt-1">The salon may be closed or fully booked on this date. Please try another date.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        @foreach($errors->all() as $error)
                                            <p class="text-sm text-red-700">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <a href="{{ route('providers.show', $provider) }}" class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-lg text-base font-medium text-gray-700 bg-white hover:bg-gray-50 text-center transition-colors duration-150">
                                Cancel
                            </a>
                            <button type="submit" :disabled="!serviceId || !appointmentDate || !selectedSlot" class="flex-1 px-6 py-3 border border-transparent rounded-lg text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150 shadow-sm">
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Provider Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Provider Details</h3>
                    <div class="flex items-start">
                        @if($provider->photo)
                            <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->name }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600">
                                {{ substr($provider->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">{{ $provider->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $provider->expertise }}</p>
                            <div class="flex items-center mt-1">
                                <x-rating-stars :rating="$provider->average_rating" size="sm" />
                                <span class="ml-1 text-sm text-gray-600">{{ number_format($provider->average_rating, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salon Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Salon Location</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div class="ml-2">
                                <p class="font-medium text-gray-900">{{ $provider->salon->name }}</p>
                                <p class="text-gray-600">{{ $provider->salon->address }}</p>
                                <p class="text-gray-600">{{ $provider->salon->city }}, {{ $provider->salon->state }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <p class="ml-2 text-gray-600">{{ $provider->salon->phone }}</p>
                        </div>
                        <div class="pt-3 border-t">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-2">
                                    <p class="font-medium text-gray-900">Hours</p>
                                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($provider->salon->opening_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($provider->salon->closing_time)->format('g:i A') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Open: {{ ucfirst(implode(', ', array_slice($provider->salon->working_days, 0, 3))) }}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function bookingForm() {
    return {
        serviceId: '{{ old('service_id') }}',
        appointmentDate: '{{ old('appointment_date') }}',
        selectedSlot: '{{ old('start_time') }}',
        selectedService: '',
        slots: [],
        loading: false,
        minDate: new Date().toISOString().split('T')[0],

        serviceChanged() {
            const select = document.getElementById('service_id');
            const option = select.options[select.selectedIndex];
            if (option.value) {
                this.selectedService = `📋 Duration: ${option.dataset.duration} minutes | 💰 Price: $${parseFloat(option.dataset.price).toFixed(2)}`;
                this.selectedSlot = '';
                this.slots = [];
                if (this.appointmentDate) {
                    this.loadSlots();
                }
            } else {
                this.selectedService = '';
            }
        },

        selectSlot(slot) {
            this.selectedSlot = slot;
        },

        async loadSlots() {
            if (!this.serviceId || !this.appointmentDate) {
                return;
            }

            this.loading = true;
            this.slots = [];
            this.selectedSlot = '';

            try {
                const response = await fetch(`/api/providers/{{ $provider->id }}/available-slots?service_id=${this.serviceId}&date=${this.appointmentDate}`);
                const data = await response.json();

                if (response.ok && data.success) {
                    this.slots = data.data.slots || [];
                }
            } catch (error) {
                console.error('Failed to load slots:', error);
            } finally {
                this.loading = false;
            }
        },

        init() {
            if (this.serviceId) {
                this.serviceChanged();
            }
        }
    }
}
</script>
@endpush
@endsection
