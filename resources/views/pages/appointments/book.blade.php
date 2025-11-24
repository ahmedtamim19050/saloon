@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<style>
    .booking-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 40px 0;
    }

    .booking-header-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #f0f0f0;
    }

    .booking-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 32px;
        border: 1px solid #f0f0f0;
    }

    .form-label-modern {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control-modern {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: #872341;
        box-shadow: 0 0 0 3px rgba(135, 35, 65, 0.1);
        outline: none;
    }

    .time-slot-btn {
        padding: 14px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        color: #374151;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .time-slot-btn:hover {
        border-color: #872341;
        background: #fef2f2;
        transform: translateY(-2px);
    }

    .time-slot-btn.selected {
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        border-color: #872341;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 24px;
        border: 1px solid #f0f0f0;
        margin-bottom: 20px;
    }

    .provider-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        border: none;
        padding: 16px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary-custom:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(135, 35, 65, 0.4);
    }

    .btn-primary-custom:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-secondary-custom {
        background: #f3f4f6;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        padding: 16px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-secondary-custom:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 2px solid #10b981;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        color: #065f46;
        font-weight: 500;
    }

    .alert-warning-custom {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        color: #92400e;
    }

    .loading-spinner {
        text-align: center;
        padding: 48px 20px;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .spinner {
        border: 4px solid #f3f4f6;
        border-top: 4px solid #872341;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

    <div class="booking-container">
    <div class="container" style="max-width: 1200px;">
        <!-- Header -->
        <div class="booking-header-card">
            <div class="d-flex align-items-center">
                <a href="{{ route('providers.show', $provider) }}" class="text-decoration-none" style="color: #6b7280; margin-right: 16px; transition: color 0.3s;" onmouseover="this.style.color='#872341'" onmouseout="this.style.color='#6b7280'">
                    <i class="bi bi-arrow-left" style="font-size: 24px;"></i>
                </a>
                <div class="flex-grow-1">
                    <h1 style="font-size: 28px; font-weight: 700; color: #111827; margin-bottom: 8px;">Book Appointment</h1>
                    <p style="color: #6b7280; margin: 0;">Schedule your appointment with {{ $provider->name }}</p>
                </div>
            </div>
        </div>        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-12 col-lg-8">
                <div class="booking-form-card">
                    <form action="{{ route('appointments.store') }}" method="POST" x-data="bookingForm()">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                        <input type="hidden" name="salon_id" value="{{ $provider->salon_id }}">

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert-success-custom d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- Service Selection -->
                        <div class="mb-4">
                            <label for="service_id" class="form-label-modern">
                                <i class="bi bi-scissors" style="color: #872341;"></i>
                                Select Service <span class="text-danger">*</span>
                            </label>
                            <select x-model="serviceId" @change="serviceChanged()" id="service_id" name="service_id" required class="form-control-modern @error('service_id') border-danger @enderror">
                                <option value="">Choose a service...</option>
                                @foreach($provider->services as $service)
                                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}" data-price="{{ $service->price }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} - ৳{{ number_format($service->price, 2) }} ({{ $service->duration }} min)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                            <div x-show="selectedService" class="mt-2 p-3" style="background: #f9fafb; border-radius: 10px; font-size: 13px; color: #6b7280;" x-text="selectedService"></div>
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-4">
                            <label for="appointment_date" class="form-label-modern">
                                <i class="bi bi-calendar-event" style="color: #872341;"></i>
                                Select Date <span class="text-danger">*</span>
                            </label>
                            <input x-model="appointmentDate" @change="loadSlots()" type="date" id="appointment_date" name="appointment_date" :min="minDate" value="{{ old('appointment_date') }}" required class="form-control-modern @error('appointment_date') border-danger @enderror">
                            @error('appointment_date')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Loading Indicator -->
                        <div x-show="loading" class="loading-spinner mb-4">
                            <div class="spinner"></div>
                            <p class="mt-3" style="color: #6b7280; font-size: 14px;">Loading available time slots...</p>
                        </div>

                        <!-- Time Slots -->
                        <div x-show="slots.length > 0 && !loading" class="mb-4">
                            <label class="form-label-modern mb-3">
                                <i class="bi bi-clock" style="color: #872341;"></i>
                                Select Time <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <template x-for="slot in slots" :key="slot">
                                    <div class="col-4 col-sm-3 col-md-2">
                                        <button type="button" @click="selectSlot(slot)" :class="selectedSlot === slot ? 'selected' : ''" class="time-slot-btn w-100">
                                            <span x-text="formatTime(slot)"></span>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <input type="hidden" name="start_time" x-model="selectedSlot">
                            @error('start_time')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- No Slots Message -->
                        <div x-show="!loading && serviceId && appointmentDate && slots.length === 0" class="alert-warning-custom mb-4 d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px; margin-top: 2px;"></i>
                            <div>
                                <p style="font-weight: 600; margin-bottom: 6px;">No available time slots</p>
                                <p style="font-size: 13px; margin: 0;">The salon may be closed or fully booked on this date. Please try another date.</p>
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
                        <div class="row g-3 mt-3">
                            <div class="col-12 col-sm-6">
                                <a href="{{ route('providers.show', $provider) }}" class="btn-secondary-custom text-center text-decoration-none d-block">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                            <div class="col-12 col-sm-6">
                                <button type="submit" :disabled="!serviceId || !appointmentDate || !selectedSlot" class="btn-primary-custom">
                                    <i class="bi bi-check-circle me-2"></i>Book Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4">
                <!-- Provider Card -->
                <div class="sidebar-card">
                    <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 20px;">Provider Details</h3>
                    <div class="d-flex gap-3">
                        @if($provider->photo)
                            <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->name }}" class="provider-avatar-large" style="object-fit: cover;">
                        @else
                            <div class="provider-avatar-large">
                                {{ strtoupper(substr($provider->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h4 style="font-weight: 600; color: #111827; margin-bottom: 4px;">{{ $provider->name }}</h4>
                            <p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">{{ $provider->expertise ?? 'Professional Barber' }}</p>
                            <div class="d-flex align-items-center gap-1">
                                <span style="color: #f59e0b;">⭐</span>
                                <span style="font-size: 13px; color: #6b7280;">{{ number_format($provider->average_rating, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salon Info -->
                <div class="sidebar-card">
                    <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 20px;">Salon Location</h3>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex gap-2">
                            <i class="bi bi-building" style="color: #872341; font-size: 18px; margin-top: 2px;"></i>
                            <div>
                                <p style="font-weight: 600; color: #111827; margin-bottom: 4px;">{{ $provider->salon->name }}</p>
                                <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px;">{{ $provider->salon->address }}</p>
                                <p style="font-size: 13px; color: #6b7280; margin: 0;">{{ $provider->salon->city }}, {{ $provider->salon->state }}</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <i class="bi bi-telephone" style="color: #872341; font-size: 18px;"></i>
                            <p style="font-size: 13px; color: #6b7280; margin: 0;">{{ $provider->salon->phone }}</p>
                        </div>
                        <div class="d-flex gap-2 pt-2" style="border-top: 1px solid #e5e7eb;">
                            <i class="bi bi-clock" style="color: #872341; font-size: 18px; margin-top: 2px;"></i>
                            <div>
                                <p style="font-weight: 600; color: #111827; margin-bottom: 4px;">Working Hours</p>
                                <p style="font-size: 13px; color: #6b7280; margin-bottom: 6px;">{{ \Carbon\Carbon::parse($provider->salon->opening_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($provider->salon->closing_time)->format('g:i A') }}</p>
                                @if($provider->salon->working_days && is_array($provider->salon->working_days))
                                    <p style="font-size: 12px; color: #9ca3af; margin: 0;">Open: {{ ucfirst(implode(', ', array_slice($provider->salon->working_days, 0, 3))) }}@if(count($provider->salon->working_days) > 3)...@endif</p>
                                @endif
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

        formatTime(time) {
            // Convert 24h format (HH:mm:ss) to 12h format (h:mm AM/PM)
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        },

        async loadSlots() {
            if (!this.serviceId || !this.appointmentDate) {
                return;
            }

            this.loading = true;
            this.slots = [];
            this.selectedSlot = '';

            try {
                const response = await fetch(`/appointments/available-slots/{{ $provider->id }}?service_id=${this.serviceId}&date=${this.appointmentDate}`);
                const data = await response.json();

                if (response.ok && data.success) {
                    this.slots = data.data.slots || [];
                } else {
                    console.error('API Error:', data);
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
