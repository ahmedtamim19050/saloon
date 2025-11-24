@extends('layouts.salon-dashboard')

@section('content')
<style>
    .earnings-header {
        background: linear-gradient(135deg, #872341, #BE3144);
        padding: 32px;
        border-radius: 16px;
        margin-bottom: 32px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .earnings-header-left h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .earnings-header-left p {
        margin: 0;
        opacity: 0.9;
    }

    .period-selector {
        display: flex;
        gap: 8px;
        background: rgba(255,255,255,0.1);
        padding: 6px;
        border-radius: 12px;
    }

    .period-btn {
        padding: 10px 20px;
        background: transparent;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .period-btn:hover {
        background: rgba(255,255,255,0.1);
    }

    .period-btn.active {
        background: white;
        color: #872341;
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #872341, #BE3144);
    }

    .summary-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .summary-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #872341, #BE3144);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    .summary-card-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-card-value {
        font-size: 32px;
        font-weight: 700;
        color: #09122C;
        margin: 8px 0;
    }

    .summary-card-detail {
        font-size: 13px;
        color: #999;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .chart-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .chart-card h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #09122C;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-container {
        height: 300px;
        position: relative;
    }

    .transactions-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .transactions-card h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #09122C;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-responsive-modern {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
    }

    .table-earnings {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 14px;
    }

    .table-earnings thead {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .table-earnings th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        color: #09122C;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table-earnings td {
        padding: 16px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-earnings tbody tr {
        transition: all 0.2s ease;
    }

    .table-earnings tbody tr:hover {
        background: #f8f9fa;
    }

    .table-earnings tbody tr:last-child td {
        border-bottom: none;
    }

    .transaction-id {
        font-weight: 600;
        color: #872341;
        font-family: monospace;
    }

    .customer-info-small {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar-mini {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 13px;
        flex-shrink: 0;
    }

    .customer-name-small {
        font-weight: 500;
        color: #09122C;
    }

    .provider-info-small {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .provider-avatar-mini {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 12px;
        flex-shrink: 0;
    }

    .provider-name-small {
        font-weight: 500;
        color: #09122C;
    }

    .service-name-small {
        font-weight: 500;
        color: #09122C;
        font-size: 13px;
    }

    .amount-column {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .amount-total {
        font-weight: 700;
        color: #09122C;
        font-size: 15px;
    }

    .amount-breakdown {
        font-size: 12px;
        color: #666;
    }

    .amount-salon {
        color: #28A745;
        font-weight: 600;
    }

    .amount-provider {
        color: #007BFF;
        font-weight: 600;
    }

    .date-small {
        font-size: 13px;
        color: #666;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #ccc;
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-size: 20px;
        font-weight: 600;
        color: #666;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #999;
        margin: 0;
    }

    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item .page-link {
        padding: 8px 14px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #872341, #BE3144);
        border-color: #872341;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        border-color: #872341;
        color: #872341;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .provider-earnings-list {
        display: grid;
        gap: 12px;
    }

    .provider-earning-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .provider-earning-item:hover {
        background: #e9ecef;
    }

    .provider-earning-name {
        font-weight: 600;
        color: #09122C;
        font-size: 14px;
    }

    .provider-earning-amounts {
        display: flex;
        gap: 16px;
        font-size: 13px;
    }

    .provider-earning-salon {
        color: #28A745;
        font-weight: 600;
    }

    .provider-earning-provider {
        color: #007BFF;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <!-- Header with Period Selector -->
    <div class="earnings-header">
        <div class="earnings-header-left">
            <h1><i class="bi bi-wallet2"></i> Earnings Management</h1>
            <p>Track and analyze your salon's earnings and transactions</p>
        </div>
        <div class="period-selector">
            <a href="{{ route('salon.earnings', ['period' => 'week']) }}" class="period-btn {{ $period === 'week' ? 'active' : '' }}">
                Week
            </a>
            <a href="{{ route('salon.earnings', ['period' => 'month']) }}" class="period-btn {{ $period === 'month' ? 'active' : '' }}">
                Month
            </a>
            <a href="{{ route('salon.earnings', ['period' => 'year']) }}" class="period-btn {{ $period === 'year' ? 'active' : '' }}">
                Year
            </a>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="summary-card-label">Total Revenue</div>
            <div class="summary-card-value">৳{{ number_format($summary['total_revenue'] ?? 0, 2) }}</div>
            <div class="summary-card-detail">
                <i class="bi bi-graph-up"></i>
                <span>Gross earnings for {{ $period }}</span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-icon" style="background: linear-gradient(135deg, #28A745, #20C997);">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div class="summary-card-label">Salon Earnings</div>
            <div class="summary-card-value">৳{{ number_format($summary['salon_earnings'] ?? 0, 2) }}</div>
            <div class="summary-card-detail">
                <i class="bi bi-percent"></i>
                <span>After commission deduction</span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-icon" style="background: linear-gradient(135deg, #007BFF, #0056B3);">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
            <div class="summary-card-label">Provider Commissions</div>
            <div class="summary-card-value">৳{{ number_format($summary['provider_commissions'] ?? 0, 2) }}</div>
            <div class="summary-card-detail">
                <i class="bi bi-people"></i>
                <span>Total paid to providers</span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-icon" style="background: linear-gradient(135deg, #FFC107, #FF9800);">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="summary-card-label">Transactions</div>
            <div class="summary-card-value">{{ $summary['transaction_count'] ?? 0 }}</div>
            <div class="summary-card-detail">
                <i class="bi bi-check-circle"></i>
                <span>Completed bookings</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="chart-section">
        <div class="chart-card">
            <h5><i class="bi bi-bar-chart"></i> Provider Earnings Breakdown</h5>
            @if($providerEarnings->count() > 0)
                <div class="provider-earnings-list">
                    @foreach($providerEarnings as $providerName => $earnings)
                        <div class="provider-earning-item">
                            <span class="provider-earning-name">{{ $providerName }}</span>
                            <div class="provider-earning-amounts">
                                <span class="provider-earning-salon">
                                    <i class="bi bi-building"></i> ৳{{ number_format($earnings['salon_amount'], 2) }}
                                </span>
                                <span class="provider-earning-provider">
                                    <i class="bi bi-person"></i> ৳{{ number_format($earnings['provider_amount'], 2) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" style="padding: 40px 20px;">
                    <i class="bi bi-inbox" style="font-size: 48px;"></i>
                    <p style="margin-top: 12px;">No earnings data for this period</p>
                </div>
            @endif
        </div>

        <div class="chart-card">
            <h5><i class="bi bi-pie-chart"></i> Earnings Distribution</h5>
            <div class="chart-container">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="transactions-card">
        <h5><i class="bi bi-list-ul"></i> Recent Transactions ({{ $walletEntries->total() }})</h5>

        @if($walletEntries->count() > 0)
            <div class="table-responsive-modern">
                <table class="table-earnings">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Provider</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Salon</th>
                            <th>Provider</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($walletEntries as $entry)
                            <tr>
                                <td>
                                    <span class="transaction-id">#{{ $entry->appointment_id }}</span>
                                </td>
                                <td>
                                    <div class="customer-info-small">
                                        <div class="customer-avatar-mini">
                                            {{ strtoupper(substr($entry->appointment->customer->name ?? 'N/A', 0, 2)) }}
                                        </div>
                                        <span class="customer-name-small">{{ $entry->appointment->customer->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="provider-info-small">
                                        <div class="provider-avatar-mini">
                                            @if($entry->appointment->provider->photo)
                                                <img src="{{ asset('storage/' . $entry->appointment->provider->photo) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                            @else
                                                {{ strtoupper(substr($entry->appointment->provider->user->name ?? 'N/A', 0, 2)) }}
                                            @endif
                                        </div>
                                        <span class="provider-name-small">{{ $entry->appointment->provider->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="service-name-small">{{ $entry->appointment->service->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="date-small">{{ $entry->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="amount-total">৳{{ number_format($entry->total_amount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="amount-salon">৳{{ number_format($entry->salon_amount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="amount-provider">৳{{ number_format($entry->provider_amount, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $walletEntries->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4>No Transactions Found</h4>
                <p>There are no transactions for this period.</p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Earnings Distribution Chart
        const ctx = document.getElementById('earningsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Salon Earnings', 'Provider Commissions'],
                    datasets: [{
                        data: [
                            {{ $summary['salon_earnings'] ?? 0 }},
                            {{ $summary['provider_commissions'] ?? 0 }}
                        ],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(0, 123, 255, 0.8)'
                        ],
                        borderColor: [
                            '#28A745',
                            '#007BFF'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += '৳' + context.parsed.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
