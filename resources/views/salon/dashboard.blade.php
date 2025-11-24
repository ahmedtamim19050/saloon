@extends('layouts.salon-dashboard')

@section('title', 'Salon Dashboard')
@section('user-role', 'Salon Owner')
@section('header', 'Dashboard')



@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .progress-bar-container {
        width: 100%;
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .monthly-progress-card {
        background: linear-gradient(135deg, #872341 0%, #BE3144 50%, #E17564 100%);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 8px 32px rgba(135, 35, 65, 0.3);
        position: relative;
        overflow: hidden;
    }

    .monthly-progress-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .progress-mini-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .progress-mini-card:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    .chart-card, .provider-card, .appointment-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .provider-item {
        padding: 16px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .provider-item:hover {
        background: #f9fafb;
        border-color: #e5e7eb;
        transform: translateX(4px);
    }

    .provider-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern thead th {
        background: #f9fafb;
        padding: 16px 24px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-modern tbody td {
        padding: 20px 24px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-size: 14px;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f9fafb;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: between;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
</style>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Total Providers Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Total Providers</p>
                    <h2 class="mb-2" style="font-size: 32px; font-weight: 700; color: #111827;">{{ $stats['total_providers'] }}</h2>
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-badge" style="background: #d1fae5; color: #065f46;">{{ $stats['active_providers'] }} Active</span>
                        @if($stats['total_providers'] > 0)
                        <span style="font-size: 12px; color: #6b7280;">{{ round(($stats['active_providers']/$stats['total_providers'])*100) }}%</span>
                        @endif
                    </div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    <i class="bi bi-people-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Today's Appointments</p>
                    <h2 class="mb-2" style="font-size: 32px; font-weight: 700; color: #111827;">{{ $stats['today_appointments'] }}</h2>
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 12px;">
                            <span class="text-muted">Completed</span>
                            <span style="font-weight: 600; color: #10b981;">{{ $stats['completed_today'] }}/{{ $stats['today_appointments'] }}</span>
                        </div>
                        @if($stats['today_appointments'] > 0)
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #10b981, #059669); width: {{ round(($stats['completed_today']/$stats['today_appointments'])*100) }}%;"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-calendar-check-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Due Appointments Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Due Appointments</p>
                    <h2 class="mb-2" style="font-size: 32px; font-weight: 700; color: #f59e0b;">{{ $stats['pending_appointments'] }}</h2>
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-badge" style="background: #fef3c7; color: #92400e;">Awaiting Action</span>
                        @if($stats['confirmed_appointments'] > 0)
                        <span style="font-size: 12px; color: #10b981;">+{{ $stats['confirmed_appointments'] }} confirmed</span>
                        @endif
                    </div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="bi bi-clock-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Total Earnings (Month)</p>
                    <h2 class="mb-2" style="font-size: 32px; font-weight: 700; color: #872341;">৳{{ number_format($monthlyRevenue['salon_earnings'], 0) }}</h2>
                    <div class="mt-2">
                        <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 12px;">
                            <span class="text-muted">Total Revenue</span>
                            <span style="font-weight: 600; color: #374151;">৳{{ number_format($monthlyRevenue['total_revenue'], 0) }}</span>
                        </div>
                        <div class="progress-bar-container" style="height: 6px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #872341, #BE3144); width: {{ $monthlyRevenue['total_revenue'] > 0 ? round(($monthlyRevenue['salon_earnings']/$monthlyRevenue['total_revenue'])*100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #872341, #BE3144);">
                    <i class="bi bi-currency-dollar" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Progress Section -->
<div class="monthly-progress-card mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4 position-relative" style="z-index: 2;">
        <div>
            <h3 class="text-white mb-1" style="font-size: 22px; font-weight: 700;">Monthly Progress</h3>
            <p class="text-white-50" style="font-size: 14px;">{{ now()->format('F Y') }}</p>
        </div>
        <div class="text-end">
            <p class="text-white mb-0" style="font-size: 36px; font-weight: 700;">{{ $stats['month_completed'] ?? 0 }}</p>
            <p class="text-white-50" style="font-size: 13px;">Completed Bookings</p>
        </div>
    </div>
    <div class="row g-3 mt-3 position-relative" style="z-index: 2;">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="progress-mini-card">
                <p class="text-white-50 mb-2" style="font-size: 11px; font-weight: 500;">Revenue Target</p>
                <p class="text-white mb-2" style="font-size: 26px; font-weight: 700;">৳{{ number_format($stats['revenue_target'] ?? 100000, 0) }}</p>
                <div class="progress-bar-container" style="background: rgba(255, 255, 255, 0.2);">
                    <div class="progress-bar" style="background: white; width: {{ min(100, ($monthlyRevenue['total_revenue'] / ($stats['revenue_target'] ?? 100000)) * 100) }}%;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="progress-mini-card">
                <p class="text-white-50 mb-2" style="font-size: 11px; font-weight: 500;">Booking Target</p>
                <p class="text-white mb-2" style="font-size: 26px; font-weight: 700;">{{ $stats['month_completed'] ?? 0 }}/{{ $stats['booking_target'] ?? 200 }}</p>
                <div class="progress-bar-container" style="background: rgba(255, 255, 255, 0.2);">
                    <div class="progress-bar" style="background: white; width: {{ min(100, (($stats['month_completed'] ?? 0) / ($stats['booking_target'] ?? 200)) * 100) }}%;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="progress-mini-card">
                <p class="text-white-50 mb-2" style="font-size: 11px; font-weight: 500;">Customer Satisfaction</p>
                <p class="text-white mb-1" style="font-size: 26px; font-weight: 700;">{{ number_format($stats['avg_rating'] ?? 0, 1) }} ⭐</p>
                <p class="text-white-50 mb-0" style="font-size: 11px;">Based on {{ $stats['total_reviews'] ?? 0 }} reviews</p>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="progress-mini-card">
                <p class="text-white-50 mb-2" style="font-size: 11px; font-weight: 500;">Growth Rate</p>
                <p class="text-white mb-1" style="font-size: 26px; font-weight: 700;">+{{ number_format($stats['growth_rate'] ?? 0, 1) }}%</p>
                <p class="text-white-50 mb-0" style="font-size: 11px;">vs last month</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Weekly Earnings Chart -->
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="section-header mb-3">
                <h3 class="section-title">Weekly Earnings</h3>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="weeklyEarningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Providers -->
    <div class="col-12 col-lg-6">
        <div class="provider-card">
            <div class="section-header mb-3">
                <h3 class="section-title">Top Providers This Month</h3>
            </div>
            <div class="d-flex flex-column gap-2">
                @forelse($topProviders as $provider)
                    <div class="provider-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="provider-avatar">
                                    @if($provider->photo)
                                        <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->user->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr($provider->user->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="mb-1" style="font-size: 14px; font-weight: 600; color: #111827;">{{ $provider->user->name }}</p>
                                    <p class="mb-0" style="font-size: 12px; color: #6b7280;">{{ $provider->completed_count }} appointments</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="mb-1" style="font-size: 14px; font-weight: 600; color: #111827;">⭐ {{ number_format($provider->average_rating, 1) }}</p>
                                <p class="mb-0" style="font-size: 12px; color: #6b7280;">{{ $provider->total_reviews }} reviews</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0">No providers found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Appointments -->
<div class="appointment-card">
    <div class="section-header" style="padding-bottom: 16px; border-bottom: 2px solid #f3f4f6;">
        <h3 class="section-title">Recent Appointments</h3>
    </div>
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Provider</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAppointments as $appointment)
                    <tr>
                        <td>
                            <span style="font-weight: 600;">{{ $appointment->user->name }}</span>
                        </td>
                        <td>{{ $appointment->provider->user->name }}</td>
                        <td>{{ $appointment->service->name }}</td>
                        <td>
                            {{ $appointment->appointment_date->format('M d, Y') }}<br>
                            <span style="font-size: 12px; color: #9ca3af;">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                        </td>
                        <td>
                            <span class="status-badge
                                @if($appointment->status === 'completed') 
                                    " style="background: #d1fae5; color: #065f46;"
                                @elseif($appointment->status === 'confirmed')
                                    " style="background: #dbeafe; color: #1e40af;"
                                @elseif($appointment->status === 'pending')
                                    " style="background: #fef3c7; color: #92400e;"
                                @else
                                    " style="background: #fee2e2; color: #991b1b;"
                                @endif>
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td><span style="font-weight: 600;">৳{{ number_format($appointment->total_price, 2) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-calendar-x"></i>
                                <p class="mb-0">No appointments found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('weeklyEarningsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($weeklyEarnings['labels']),
                    datasets: [{
                        label: 'Earnings (৳)',
                        data: @json($weeklyEarnings['data']),
                        borderColor: '#872341',
                        backgroundColor: 'rgba(135, 35, 65, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#872341',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            borderColor: '#872341',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280',
                                callback: function(value) {
                                    return '৳' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
