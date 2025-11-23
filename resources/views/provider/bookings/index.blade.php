<x-provider-dashboard title="My Bookings">
    <!-- Filter Form -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-bold mb-0">My Bookings</h1>
            <form method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                        <strong>{{ strtoupper(substr($appointment->user->name, 0, 2)) }}</strong>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $appointment->user->name }}</div>
                                        <small class="text-muted">{{ $appointment->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $appointment->service->name }}</div>
                                <small class="text-muted">{{ $appointment->service->duration }} mins</small>
                            </td>
                            <td class="fw-bold">৳{{ number_format($appointment->service->price, 0) }}</td>
                            <td>
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-primary">Confirmed</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->status === 'pending')
                                    <form method="POST" action="{{ route('provider.bookings.update-status', $appointment) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                    </form>
                                @elseif($appointment->status === 'confirmed')
                                    <form method="POST" action="{{ route('provider.bookings.update-status', $appointment) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-primary">Complete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No bookings found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($appointments->hasPages())
        <div class="card-footer">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>
</x-provider-dashboard>
