<x-customer-dashboard title="My Dashboard">
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Total Appointments Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Total Appointments</p>
                        <h3 class="fw-bold mb-2">{{ $stats['total_appointments'] }}</h3>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark">All Time</span>
                            @if($stats['completed_appointments'] > 0)
                            <small class="text-success">{{ $stats['completed_appointments'] }} done</small>
                            @endif
                        </div>
                    </div>
                    <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                        <i class="bi bi-clipboard-check text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Upcoming Bookings</p>
                        <h3 class="fw-bold text-primary mb-2">{{ $stats['upcoming_appointments'] }}</h3>
                        <span class="badge bg-primary">Confirmed & Pending</span>
                    </div>
                    <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                        <i class="bi bi-calendar-check text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Appointments Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Completed Services</p>
                        <h3 class="fw-bold text-success mb-2">{{ $stats['completed_appointments'] }}</h3>
                        <div>
                            <small class="text-muted d-block">Total Spent</small>
                            <strong class="fs-6">৳{{ number_format($stats['total_spent'], 0) }}</strong>
                        </div>
                    </div>
                    <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                        <i class="bi bi-check-circle text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payments Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Pending Payments</p>
                        <h3 class="fw-bold text-danger mb-2">{{ $stats['pending_payments'] }}</h3>
                        <div>
                            <small class="text-muted d-block">Amount Due</small>
                            <strong class="text-danger fs-6">৳{{ number_format($stats['pending_payments_amount'], 0) }}</strong>
                        </div>
                    </div>
                    <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                        <i class="bi bi-credit-card text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Payments Alert -->
@if($stats['pending_payments'] > 0)
<div class="alert alert-warning border-start border-warning border-4 mb-4">
    <div class="d-flex align-items-start">
        <div class="flex-shrink-0">
            <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
        </div>
        <div class="ms-3 flex-grow-1">
            <h5 class="alert-heading">You have {{ $stats['pending_payments'] }} pending payment(s)</h5>
            <p class="mb-3">Total amount due: ৳{{ number_format($stats['pending_payments_amount'], 0) }}. Please complete your payments to avoid service interruption.</p>
            @if($needsPayment->count() > 0)
            <div class="vstack gap-2">
                @foreach($needsPayment as $appointment)
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 fw-semibold">{{ $appointment->service->name }} at {{ $appointment->salon->name }}</p>
                                <small class="text-muted">{{ $appointment->appointment_date->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fw-bold">৳{{ number_format($appointment->total_price, 0) }}</span>
                                <a href="{{ route('customer.payment', $appointment) }}" class="btn btn-warning btn-sm">
                                    Pay Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<div class="row g-4 mb-4">
    <!-- Upcoming Appointments -->
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header" style="background: linear-gradient(135deg, #e7f0ff 0%, #e9ecef 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-semibold">Upcoming Appointments</h5>
                        <small class="text-muted">Your scheduled services</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">
                        {{ $upcomingAppointments->count() }}
                    </span>
                </div>
            </div>
            <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                <div class="vstack gap-3">
                    @forelse($upcomingAppointments as $appointment)
                        <div class="card border-start border-primary border-4 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $appointment->salon->name }}</h6>
                                        <p class="mb-2 small text-muted">
                                            <strong>{{ $appointment->provider->user->name }}</strong> • {{ $appointment->service->name }}
                                        </p>
                                        <div class="d-flex gap-3 small text-muted">
                                            <span>
                                                <i class="bi bi-calendar3"></i> {{ $appointment->appointment_date->format('M d, Y') }}
                                            </span>
                                            <span>
                                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <p class="mb-2 fw-bold fs-5">৳{{ number_format($appointment->total_price, 0) }}</p>
                                        <span class="badge {{ $appointment->status === 'confirmed' ? 'bg-primary' : 'bg-warning' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted fw-semibold mt-3">No upcoming appointments</p>
                            <small class="text-muted">Book your next service now!</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-semibold">Recent History</h5>
                        <small class="text-muted">Your past appointments</small>
                    </div>
                    <a href="{{ route('customer.bookings') }}" class="btn btn-sm btn-link text-decoration-none">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                <div class="vstack gap-3">
                    @forelse($recentAppointments as $appointment)
                        <div class="card bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $appointment->salon->name }}</h6>
                                        <p class="mb-2 small text-muted">{{ $appointment->service->name }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i> {{ $appointment->appointment_date->format('M d, Y') }} • 
                                            <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}
                                        </small>
                                    </div>
                                    <div class="text-end ms-3">
                                        <p class="mb-2 fw-semibold">৳{{ number_format($appointment->total_price, 0) }}</p>
                                        <span class="badge mb-2 
                                            @if($appointment->status === 'completed') bg-success
                                            @elseif($appointment->status === 'confirmed') bg-primary
                                            @elseif($appointment->status === 'pending') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        <div class="vstack gap-1">
                                            @if($appointment->canBePaid())
                                                <a href="{{ route('customer.payment', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-credit-card"></i> Pay Now
                                                </a>
                                            @endif
                                            @if($appointment->canBeReviewed() && !$appointment->review_submitted)
                                                <a href="{{ route('customer.review', $appointment) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-star"></i> Review
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted fw-semibold mt-3">No appointment history</p>
                            <small class="text-muted">Start booking to see your history</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card text-white shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="card-body p-4">
        <h3 class="fw-bold fs-4 mb-2">Ready to book your next appointment?</h3>
        <p class="mb-3 opacity-75">Browse our salons and find the perfect service for you.</p>
        <a href="{{ route('salons.index') }}" class="btn btn-light btn-lg">
            <i class="bi bi-search me-2"></i> Browse Salons
        </a>
    </div>
</div>
</x-customer-dashboard>
