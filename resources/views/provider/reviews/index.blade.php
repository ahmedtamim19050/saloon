<x-provider-dashboard title="Customer Reviews">
    <h1 class="h3 fw-bold mb-4">Customer Reviews</h1>

    <!-- Overall Rating Summary -->
    <div class="card shadow-sm border-0 text-white mb-4" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4 text-center border-end border-light">
                    <p class="small mb-2 opacity-75">Average Rating</p>
                    <h1 class="display-3 fw-bold mb-2">{{ number_format($provider->averageRating(), 1) }}</h1>
                    <div class="d-flex justify-content-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($provider->averageRating()))
                                <i class="bi bi-star-fill text-warning fs-5"></i>
                            @else
                                <i class="bi bi-star fs-5 opacity-50"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="col-md-4 text-center border-end border-light">
                    <p class="small mb-2 opacity-75">Total Reviews</p>
                    <h1 class="display-3 fw-bold mb-2">{{ $provider->reviews()->count() }}</h1>
                    <p class="small opacity-75">From customers</p>
                </div>

                <div class="col-md-4 text-center">
                    <p class="small mb-2 opacity-75">Completion Rate</p>
                    <h1 class="display-3 fw-bold mb-2">{{ $provider->completionRate() }}%</h1>
                    <p class="small opacity-75">Bookings completed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    @forelse($reviews as $review)
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <strong class="fs-5">{{ strtoupper(substr($review->user->name, 0, 2)) }}</strong>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $review->user->name }}</h6>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="bi bi-star-fill text-warning"></i>
                        @else
                            <i class="bi bi-star text-muted"></i>
                        @endif
                    @endfor
                    <span class="ms-2 fw-bold">{{ $review->rating }}.0</span>
                </div>
            </div>

            @if($review->comment)
            <p class="mb-3">{{ $review->comment }}</p>
            @endif

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <div class="text-muted small">
                    <i class="bi bi-briefcase me-1"></i>
                    {{ $review->appointment->service->name }}
                </div>
                <div class="text-muted small">
                    {{ \Carbon\Carbon::parse($review->appointment->appointment_date)->format('M d, Y') }}
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">
            <i class="bi bi-star fs-1 text-muted"></i>
            <h5 class="mt-3">No reviews yet</h5>
            <p class="text-muted">Complete bookings to start receiving customer reviews</p>
        </div>
    </div>
    @endforelse

    @if($reviews->hasPages())
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
    @endif
</x-provider-dashboard>
