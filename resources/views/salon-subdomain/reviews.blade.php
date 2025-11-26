@extends('salon-subdomain.layout')

@section('title', 'Reviews - ' . $currentSalon->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mb-4 text-center">
                <h2><i class="bi bi-star-fill text-warning"></i> Customer Reviews</h2>
                <p class="text-muted">See what our customers say about us</p>
                
                @if($currentSalon->reviews->count() > 0)
                    <div class="my-4">
                        <div class="display-4 fw-bold text-warning">
                            {{ number_format($currentSalon->reviews->avg('rating'), 1) }}
                        </div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($currentSalon->reviews->avg('rating')))
                                    <i class="bi bi-star-fill text-warning fs-4"></i>
                                @else
                                    <i class="bi bi-star text-warning fs-4"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted">Based on {{ $currentSalon->reviews->count() }} reviews</p>
                    </div>
                @endif
            </div>

            @if($currentSalon->reviews->count() > 0)
                <div class="row g-4">
                    @foreach($currentSalon->reviews as $review)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start gap-3">
                                    @if($review->customer && $review->customer->image)
                                        <img src="{{ asset('storage/' . $review->customer->image) }}" 
                                             alt="{{ $review->customer->name }}" 
                                             class="rounded-circle" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px; background: var(--gradient-coral); color: white; font-size: 1.5rem; font-weight: 700;">
                                            {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-0">{{ $review->customer->name ?? 'Customer' }}</h5>
                                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-person text-primary"></i>
                                            Provider: {{ $review->provider->user->name ?? 'N/A' }}
                                        </p>
                                        
                                        @if($review->comment)
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="bi bi-chat-quote fs-1 d-block mb-3"></i>
                    <h5>No Reviews Yet</h5>
                    <p class="mb-0">Be the first to review us!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
