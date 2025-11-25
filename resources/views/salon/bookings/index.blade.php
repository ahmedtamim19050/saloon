@extends('layouts.salon-dashboard')

@section('content')
<style>
    .bookings-header {
        background: linear-gradient(135deg, #872341, #BE3144);
        padding: 32px;
        border-radius: 16px;
        margin-bottom: 32px;
        color: white;
    }

    .bookings-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .bookings-header p {
        margin: 0;
        opacity: 0.9;
    }

    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .filter-card h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #09122C;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: end;
    }

    .form-group-modern {
        margin: 0;
    }

    .form-group-modern label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #666;
        margin-bottom: 6px;
    }

    .form-control-filter {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control-filter:focus {
        outline: none;
        border-color: #872341;
        box-shadow: 0 0 0 3px rgba(135, 35, 65, 0.1);
    }

    .btn-filter {
        padding: 10px 24px;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3);
    }

    .btn-reset {
        padding: 10px 24px;
        background: #f5f5f5;
        color: #666;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        background: #e0e0e0;
        color: #333;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card-mini {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-card-mini .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #09122C;
        margin-bottom: 4px;
    }

    .stat-card-mini .stat-label {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }

    .stat-card-mini.pending {
        border-left: 4px solid #FFA500;
    }

    .stat-card-mini.confirmed {
        border-left: 4px solid #007BFF;
    }

    .stat-card-mini.completed {
        border-left: 4px solid #28A745;
    }

    .stat-card-mini.cancelled {
        border-left: 4px solid #DC3545;
    }

    .bookings-table-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .bookings-table-card h5 {
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

    .table-bookings {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 14px;
    }

    .table-bookings thead {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .table-bookings th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        color: #09122C;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table-bookings td {
        padding: 16px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-bookings tbody tr {
        transition: all 0.2s ease;
    }

    .table-bookings tbody tr:hover {
        background: #f8f9fa;
    }

    .table-bookings tbody tr:last-child td {
        border-bottom: none;
    }

    .booking-id {
        font-weight: 600;
        color: #872341;
        font-family: monospace;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #872341, #BE3144);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .customer-details {
        display: flex;
        flex-direction: column;
    }

    .customer-name {
        font-weight: 600;
        color: #09122C;
        margin-bottom: 2px;
    }

    .customer-email {
        font-size: 12px;
        color: #666;
    }

    .provider-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .provider-avatar-small {
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

    .provider-name {
        font-weight: 500;
        color: #09122C;
    }

    .service-name {
        font-weight: 500;
        color: #09122C;
    }

    .service-duration {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
    }

    .datetime-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #09122C;
        font-weight: 500;
    }

    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-badge.pending {
        background: #FFF3CD;
        color: #856404;
    }

    .status-badge.confirmed {
        background: #CCE5FF;
        color: #004085;
    }

    .status-badge.completed {
        background: #D4EDDA;
        color: #155724;
    }

    .status-badge.cancelled {
        background: #F8D7DA;
        color: #721C24;
    }

    .payment-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .payment-badge.paid {
        background: #D4EDDA;
        color: #155724;
    }

    .payment-badge.pending {
        background: #FFF3CD;
        color: #856404;
    }

    .payment-badge.failed {
        background: #F8D7DA;
        color: #721C24;
    }

    .price-amount {
        font-weight: 700;
        color: #09122C;
        font-size: 15px;
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
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="bookings-header">
        <h1><i class="bi bi-calendar-check"></i> Bookings Management</h1>
        <p>Manage all your salon appointments and bookings</p>
    </div>

    <!-- Statistics -->
    <div class="stats-row">
        <div class="stat-card-mini pending">
            <div class="stat-value">{{ $appointments->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card-mini confirmed">
            <div class="stat-value">{{ $appointments->where('status', 'confirmed')->count() }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
        <div class="stat-card-mini completed">
            <div class="stat-value">{{ $appointments->where('status', 'completed')->count() }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card-mini cancelled">
            <div class="stat-value">{{ $appointments->where('status', 'cancelled')->count() }}</div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <h5><i class="bi bi-funnel"></i> Filter Bookings</h5>
        <form method="GET" action="{{ route('salon.bookings') }}" class="filter-form">
            <div class="form-group-modern">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control-filter">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="form-group-modern">
                <label for="provider_id">Provider</label>
                <select name="provider_id" id="provider_id" class="form-control-filter">
                    <option value="">All Providers</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-modern">
                <label for="date_from">From Date</label>
                <input type="date" name="date_from" id="date_from" class="form-control-filter" value="{{ request('date_from') }}">
            </div>

            <div class="form-group-modern">
                <label for="date_to">To Date</label>
                <input type="date" name="date_to" id="date_to" class="form-control-filter" value="{{ request('date_to') }}">
            </div>

            <div class="form-group-modern">
                <label>&nbsp;</label>
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
            </div>

            @if(request()->hasAny(['status', 'provider_id', 'date_from', 'date_to']))
                <div class="form-group-modern">
                    <label>&nbsp;</label>
                    <a href="{{ route('salon.bookings') }}" class="btn-reset">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bookings-table-card">
        <h5><i class="bi bi-list-ul"></i> All Bookings ({{ $appointments->total() }})</h5>

        @if($appointments->count() > 0)
            <div class="table-responsive-modern">
                <table class="table-bookings">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Provider</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>
                                    <span class="booking-id">#{{ $appointment->id }}</span>
                                </td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">
                                            {{ strtoupper(substr($appointment->user->name, 0, 2)) }}
                                        </div>
                                        <div class="customer-details">
                                            <div class="customer-name">{{ $appointment->user->name }}</div>
                                            <div class="customer-email">{{ $appointment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="provider-info">
                                        <div class="provider-avatar-small">
                                            @if($appointment->provider->photo)
                                                <img src="{{ asset('storage/' . $appointment->provider->photo) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                            @else
                                                {{ strtoupper(substr($appointment->provider->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <span class="provider-name">{{ $appointment->provider->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="service-name">{{ $appointment->service->name }}</div>
                                    <div class="service-duration">
                                        <i class="bi bi-clock"></i> {{ $appointment->service->duration }} min
                                    </div>
                                </td>
                                <td>
                                    <div class="datetime-info">
                                        <span class="date-badge">
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        </span>
                                        <span class="time-badge">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $appointment->status }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($appointment->payment)
                                        <span class="payment-badge {{ $appointment->payment->payment_status }}">
                                            {{ ucfirst($appointment->payment->payment_status) }}
                                        </span>
                                    @else
                                        <span class="payment-badge pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="price-amount">{{ Settings::formatPrice($appointment->total_price) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <h4>No Bookings Found</h4>
                <p>There are no bookings matching your criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection
