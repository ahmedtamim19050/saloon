<x-provider-dashboard title="My Wallet">
    <h1 class="h3 fw-bold mb-4">My Wallet</h1>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-gradient text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="card-body">
                    <p class="small mb-1 opacity-75">Current Balance</p>
                    <h3 class="fw-bold mb-0">৳{{ number_format($summary['balance'], 0) }}</h3>
                    <small class="opacity-75">Available to withdraw</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-gradient text-white" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <div class="card-body">
                    <p class="small mb-1 opacity-75">Total Earnings</p>
                    <h3 class="fw-bold mb-0">৳{{ number_format($summary['total_earnings'], 0) }}</h3>
                    <small class="opacity-75">All time earnings</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-gradient text-white" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <div class="card-body">
                    <p class="small mb-1 opacity-75">This Month</p>
                    <h3 class="fw-bold mb-0">৳{{ number_format($summary['month_earnings'], 0) }}</h3>
                    <small class="opacity-75">{{ now()->format('F Y') }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-gradient text-white" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                <div class="card-body">
                    <p class="small mb-1 opacity-75">Pending</p>
                    <h3 class="fw-bold mb-0">৳{{ number_format($summary['pending'], 0) }}</h3>
                    <small class="opacity-75">From completed bookings</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trend Chart -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Earnings Trend (Last 6 Months)</h5>
        </div>
        <div class="card-body">
            <canvas id="monthlyTrendChart" height="80"></canvas>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Transaction History</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($walletEntries as $entry)
                        <tr>
                            <td>{{ $entry->created_at->format('M d, Y g:i A') }}</td>
                            <td>
                                <span class="badge bg-{{ $entry->type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($entry->type) }}
                                </span>
                            </td>
                            <td>{{ $entry->description }}</td>
                            <td class="text-end fw-bold text-{{ $entry->type === 'credit' ? 'success' : 'danger' }}">
                                {{ $entry->type === 'credit' ? '+' : '-' }}৳{{ number_format($entry->total_provider_amount, 0) }}
                            </td>
                            <td class="text-end fw-bold">৳{{ number_format($entry->balance_after, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-wallet2 fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No transactions yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($walletEntries->hasPages())
        <div class="card-footer">
            {{ $walletEntries->links() }}
        </div>
        @endif
    </div>
</x-provider-dashboard>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyTrend->pluck('month')) !!},
            datasets: [{
                label: 'Monthly Earnings',
                data: {!! json_encode($monthlyTrend->pluck('total')) !!},
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '৳' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
