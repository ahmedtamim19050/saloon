<x-provider-dashboard title="Settings">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Availability Settings -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-clock me-2"></i>
                        Availability Settings
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('provider.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Working Hours -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Working Hours</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label small">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', auth()->user()->start_time ?? '09:00') }}" 
                                           class="form-control @error('start_time') is-invalid @enderror">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="end_time" class="form-label small">End Time</label>
                                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', auth()->user()->end_time ?? '18:00') }}" 
                                           class="form-control @error('end_time') is-invalid @enderror">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Working Days -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Working Days</label>
                            <div class="row g-2">
                                @php
                                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    $workingDays = old('working_days', auth()->user()->working_days ?? ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']);
                                @endphp
                                @foreach($days as $day)
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day-{{ $day }}"
                                               {{ in_array($day, (array)$workingDays) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="day-{{ $day }}">
                                            {{ $day }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('working_days')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Break Time -->
                        <div class="mb-4 pt-3 border-top">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="has_break" id="has_break" value="1" 
                                       {{ old('has_break', auth()->user()->has_break ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="has_break">
                                    I take a break during work hours
                                </label>
                            </div>

                            <div id="break-time-fields" class="row g-3" style="display: {{ old('has_break', auth()->user()->has_break ?? false) ? 'flex' : 'none' }};">
                                <div class="col-md-6">
                                    <label for="break_start" class="form-label small">Break Start</label>
                                    <input type="time" name="break_start" id="break_start" value="{{ old('break_start', auth()->user()->break_start ?? '13:00') }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="break_end" class="form-label small">Break End</label>
                                    <input type="time" name="break_end" id="break_end" value="{{ old('break_end', auth()->user()->break_end ?? '14:00') }}" 
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Save Availability Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);">
                    <h5 class="mb-0 text-white d-flex align-items-center">
                        <i class="bi bi-bell me-2"></i>
                        Notification Preferences
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('provider.settings.notifications') }}" method="POST">
                        @csrf
                        @method('PUT')

                        @php
                            $notifications = [
                                'new_booking' => ['title' => 'New Booking Notifications', 'description' => 'Get notified when you receive a new booking request'],
                                'booking_confirmation' => ['title' => 'Booking Confirmations', 'description' => 'Get notified when a booking is confirmed'],
                                'booking_cancellation' => ['title' => 'Booking Cancellations', 'description' => 'Get notified when a booking is cancelled'],
                                'payment_received' => ['title' => 'Payment Notifications', 'description' => 'Get notified when you receive payments'],
                                'review_received' => ['title' => 'Review Notifications', 'description' => 'Get notified when customers leave reviews'],
                            ];
                        @endphp

                        <div class="list-group list-group-flush">
                            @foreach($notifications as $key => $notification)
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="notifications[{{ $key }}]" value="1" 
                                           id="notif-{{ $key }}"
                                           {{ old("notifications.{$key}", auth()->user()->notifications[$key] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex flex-column" for="notif-{{ $key }}">
                                        <span class="fw-bold">{{ $notification['title'] }}</span>
                                        <small class="text-muted">{{ $notification['description'] }}</small>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Save Notification Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-provider-dashboard>

@push('scripts')
<script>
    document.getElementById('has_break').addEventListener('change', function() {
        const breakFields = document.getElementById('break-time-fields');
        breakFields.style.display = this.checked ? 'flex' : 'none';
    });
</script>
@endpush
