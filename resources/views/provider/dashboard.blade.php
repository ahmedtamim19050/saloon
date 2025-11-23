<x-provider-dashboard title="Provider Dashboard">
    <h1 class="h3 fw-bold mb-4">Provider Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Today's Appointments</p>
                            <h3 class="fw-bold mb-0">{{ $stats['today_appointments'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-calendar-check fs-4 text-success"></i>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $stats['today_appointments'] > 0 ? round(($stats['completed_today']/$stats['today_appointments'])*100) : 0 }}%"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">{{ $stats['completed_today'] ?? 0 }}/{{ $stats['today_appointments'] ?? 0 }} completed</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Pending Bookings</p>
                            <h3 class="fw-bold mb-0">{{ $stats['pending_appointments'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-clock-history fs-4 text-warning"></i>
                        </div>
                    </div>
                    <span class="badge bg-warning">Need Action</span>
                    @if(($stats['confirmed_appointments'] ?? 0) > 0)
                        <span class="badge bg-success ms-1">+{{ $stats['confirmed_appointments'] }} confirmed</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Wallet Balance</p>
                            <h3 class="fw-bold mb-0">৳{{ number_format($stats['wallet_balance'] ?? 0, 0) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-wallet2 fs-4 text-primary"></i>
                        </div>
                    </div>
                    <small class="text-muted">Available to withdraw</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Rating & Reviews</p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['average_rating'] ?? 0, 1) }} ⭐</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-star-fill fs-4 text-info"></i>
                        </div>
                    </div>
                    <span class="badge bg-info">{{ $stats['total_reviews'] ?? 0 }} reviews</span>
                    @if(($stats['average_rating'] ?? 0) >= 4.5)
                        <span class="badge bg-success ms-1">Excellent!</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Performance -->
    <div class="card shadow-sm border-0 mb-4 text-white" style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Monthly Performance</h5>
                    <p class="small mb-0 opacity-75">{{ now()->format('F Y') }}</p>
                </div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $stats['month_completed'] ?? 0 }}</h2>
                    <p class="small mb-0 opacity-75">Completed This Month</p>
                </div>
            </div>
            
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="bg-white bg-opacity-10 rounded p-3">
                        <p class="small mb-1 opacity-75">Earnings Target</p>
                        <h5 class="fw-bold mb-2">৳{{ number_format($stats['earnings_target'] ?? 50000, 0) }}</h5>
                        <div class="progress bg-white bg-opacity-20" style="height: 8px;">
                            <div class="progress-bar bg-white" role="progressbar" 
                                 style="width: {{ min(100, (($stats['current_month_earnings'] ?? 0) / ($stats['earnings_target'] ?? 1)) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white bg-opacity-10 rounded p-3">
                        <p class="small mb-1 opacity-75">Booking Target</p>
                        <h5 class="fw-bold mb-2">{{ $stats['month_completed'] ?? 0 }}/{{ $stats['booking_target'] ?? 100 }}</h5>
                        <div class="progress bg-white bg-opacity-20" style="height: 8px;">
                            <div class="progress-bar bg-white" role="progressbar" 
                                 style="width: {{ min(100, (($stats['month_completed'] ?? 0) / ($stats['booking_target'] ?? 1)) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white bg-opacity-10 rounded p-3">
                        <p class="small mb-1 opacity-75">Customer Satisfaction</p>
                        <h5 class="fw-bold mb-2">{{ number_format($stats['average_rating'] ?? 0, 1) }} ⭐</h5>
                        <p class="small mb-0 opacity-75">Based on {{ $stats['total_reviews'] ?? 0 }} reviews</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white bg-opacity-10 rounded p-3">
                        <p class="small mb-1 opacity-75">Growth Rate</p>
                        <h5 class="fw-bold mb-2 {{ ($stats['growth_rate'] ?? 0) >= 0 ? '' : 'text-danger' }}">
                            {{ ($stats['growth_rate'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($stats['growth_rate'] ?? 0, 1) }}%
                        </h5>
                        <p class="small mb-0 opacity-75">vs last month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's & Upcoming Appointments -->
    <div class="row g-3 mb-4">
        <!-- Today's Appointments -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i>Today's Appointments</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($todayAppointments ?? [] as $appointment)
                        <div class="d-flex align-items-start p-3 mb-2 bg-light rounded border-start border-4 
                            @if($appointment->status === 'completed') border-success
                            @elseif($appointment->status === 'confirmed') border-primary
                            @else border-warning
                            @endif">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $appointment->user->name }}</h6>
                                <p class="mb-1 text-muted small">{{ $appointment->service->name }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</small>
                            </div>
                            <span class="badge 
                                @if($appointment->status === 'completed') bg-success
                                @elseif($appointment->status === 'confirmed') bg-primary
                                @else bg-warning
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No appointments today</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Upcoming Appointments</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($upcomingAppointments ?? [] as $appointment)
                        <div class="d-flex justify-content-between align-items-start p-3 mb-2 bg-light rounded">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $appointment->user->name }}</h6>
                                <p class="mb-1 text-muted small">{{ $appointment->service->name }}</p>
                                <small class="text-muted">
                                    {{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}
                                </small>
                            </div>
                            <span class="fw-bold text-primary">৳{{ number_format($appointment->total_price ?? 0, 0) }}</span>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-check fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No upcoming appointments</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Earnings Chart -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Weekly Earnings</h5>
        </div>
        <div class="card-body">
            <canvas id="weeklyEarningsChart" height="100"></canvas>
        </div>
    </div>
</x-provider-dashboard>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('weeklyEarningsChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($weeklyEarnings['labels'] ?? []),
            datasets: [{
                label: 'Earnings (৳)',
                data: @json($weeklyEarnings['data'] ?? []),
                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                borderColor: 'rgb(13, 110, 253)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
