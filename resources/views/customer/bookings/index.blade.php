<x-customer-dashboard title="My Bookings">
<div class="mb-4">
    <h2 class="fw-bold">My Bookings</h2>
    <p class="text-muted">View and manage all your appointments</p>
</div>

<!-- Filter Tabs -->
<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link active" href="#all" data-bs-toggle="pill">All</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#upcoming" data-bs-toggle="pill">Upcoming</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#completed" data-bs-toggle="pill">Completed</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#cancelled" data-bs-toggle="pill">Cancelled</a>
    </li>
</ul>

<!-- Appointments List -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Salon</th>
                        <th>Service</th>
                        <th>Provider</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</small>
                            </td>
                            <td>{{ $appointment->salon->name }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->provider->user->name }}</td>
                            <td class="fw-semibold">৳{{ number_format($appointment->service->price, 0) }}</td>
                            <td>
                                <span class="badge 
                                    @if($appointment->status === 'completed') bg-success
                                    @elseif($appointment->status === 'confirmed') bg-primary
                                    @elseif($appointment->status === 'pending') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $appointment->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($appointment->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($appointment->canBePaid())
                                        <a href="{{ route('customer.payment', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-credit-card"></i> Pay
                                        </a>
                                    @endif
                                    @if($appointment->canBeReviewed() && !$appointment->review_submitted)
                                        <a href="{{ route('customer.review', $appointment) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-star"></i> Review
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">No bookings found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $appointments->links() }}
</div>
</x-customer-dashboard>
