@extends('layouts.salon-dashboard')

@section('title', 'Providers')
@section('header', 'Providers Management')

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

    .provider-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        overflow: hidden;
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .rating-display {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: #fef3c7;
        border-radius: 20px;
    }

    .section-header {
        padding: 24px;
        border-bottom: 2px solid #f3f4f6;
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

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Total Providers</p>
                    <h2 class="mb-0" style="font-size: 32px; font-weight: 700; color: #111827;">{{ $providers->total() }}</h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    <i class="bi bi-people-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Active Providers</p>
                    <h2 class="mb-0" style="font-size: 32px; font-weight: 700; color: #10b981;">{{ $providers->where('is_active', true)->count() }}</h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-check-circle-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Total Appointments</p>
                    <h2 class="mb-0" style="font-size: 32px; font-weight: 700; color: #111827;">{{ $providers->sum('total_appointments') }}</h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                    <i class="bi bi-calendar-event-fill" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <p class="text-muted mb-1" style="font-size: 13px; font-weight: 500;">Completed</p>
                    <h2 class="mb-0" style="font-size: 32px; font-weight: 700; color: #872341;">{{ $providers->sum('completed_appointments') }}</h2>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #872341, #BE3144);">
                    <i class="bi bi-check2-square" style="font-size: 24px; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="provider-table-card">
    <div class="section-header d-flex align-items-center justify-content-between">
        <h3 class="section-title">All Providers</h3>
        <a href="{{ route('salon.providers.create') }}" class="btn" style="background: linear-gradient(135deg, #872341, #BE3144); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 12px rgba(135, 35, 65, 0.3); transition: all 0.3s ease;">
            <i class="bi bi-plus-circle me-2"></i>Add New Provider
        </a>
    </div>
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Provider</th>
                    <th>Services</th>
                    <th>Rating</th>
                    <th>Appointments</th>
                    <th>Total Earnings</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($providers as $provider)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="provider-avatar">
                                    @if($provider->photo)
                                        <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr($provider->user->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="mb-1" style="font-size: 14px; font-weight: 600; color: #111827;">{{ $provider->user->name }}</p>
                                    <p class="mb-0" style="font-size: 12px; color: #6b7280;">{{ $provider->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #6366f1;">{{ $provider->services->count() }}</span>
                            <span style="color: #6b7280; font-size: 13px;"> services</span>
                        </td>
                        <td>
                            <div class="rating-display">
                                <span style="color: #f59e0b; font-size: 16px;">⭐</span>
                                <span style="font-weight: 600; color: #111827;">{{ number_format($provider->average_rating, 1) }}</span>
                                <span style="color: #6b7280; font-size: 11px;">({{ $provider->reviews_count }})</span>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #10b981;">{{ $provider->completed_appointments }}</span>
                            <span style="color: #6b7280;"> / {{ $provider->total_appointments }}</span>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: #872341; font-size: 15px;">৳{{ number_format($provider->wallet_entries_sum_total_provider_amount ?? 0, 2) }}</span>
                        </td>
                        <td>
                            <span class="status-badge" style="background: {{ $provider->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $provider->is_active ? '#065f46' : '#991b1b' }};">
                                {{ $provider->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                <p class="mb-0">No providers found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 24px; border-top: 1px solid #f3f4f6;">
        {{ $providers->links() }}
    </div>
</div>
@endsection
