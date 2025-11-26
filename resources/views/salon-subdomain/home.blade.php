@extends('salon-subdomain.layout')

@section('title', 'About - ' . $currentSalon->name)

@section('content')
<div class="container py-4">
    <!-- About Content -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <i class="bi bi-people-fill fs-2 text-primary mb-2"></i>
                            <h4 class="mb-0 fw-bold">{{ $currentSalon->providers->count() }}</h4>
                            <small class="text-muted">Providers</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <i class="bi bi-chat-quote-fill fs-2 text-warning mb-2"></i>
                            <h4 class="mb-0 fw-bold">{{ $currentSalon->reviews->count() }}</h4>
                            <small class="text-muted">Reviews</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <i class="bi bi-heart-fill fs-2 text-danger mb-2"></i>
                            <h4 class="mb-0 fw-bold">{{ $currentSalon->followers_count }}</h4>
                            <small class="text-muted">Followers</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <i class="bi bi-scissors fs-2 text-success mb-2"></i>
                            <h4 class="mb-0 fw-bold">{{ $currentSalon->services->count() }}</h4>
                            <small class="text-muted">Services</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-3"><i class="bi bi-info-circle text-primary"></i> About Us</h3>
                    <p class="text-muted mb-0" style="line-height: 1.8;">
                        {{ $currentSalon->full_description ?? $currentSalon->description }}
                    </p>
                </div>
            </div>

            <!-- Services Preview -->
            @if($currentSalon->services->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0"><i class="bi bi-scissors text-primary"></i> Our Services</h3>
                        <a href="{{ route('salon.services', $currentSalon->slug) }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="row g-3">
                        @foreach($currentSalon->services->take(4) as $service)
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded p-2">
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $service->name }}</h6>
                                    <small class="text-muted">{{ $service->duration }} min</small>
                                    <span class="mx-2">•</span>
                                    <small class="text-primary fw-bold">{{ Settings::formatPrice($service->price) }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Location Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3"><i class="bi bi-geo-alt-fill text-danger"></i> Location</h5>
                    <p class="text-muted mb-2">
                        <i class="bi bi-pin-map"></i> {{ $currentSalon->address }}
                    </p>
                    <p class="text-muted mb-2">
                        <i class="bi bi-building"></i> {{ $currentSalon->city ?? 'N/A' }}
                    </p>
                    @if($currentSalon->state)
                    <p class="text-muted mb-0">
                        <i class="bi bi-map"></i> {{ $currentSalon->state }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3"><i class="bi bi-telephone-fill text-primary"></i> Contact</h5>
                    <p class="text-muted mb-2">
                        <i class="bi bi-phone"></i> {{ $currentSalon->phone }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="bi bi-envelope"></i> {{ $currentSalon->email }}
                    </p>
                </div>
            </div>

            <!-- Working Hours Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3"><i class="bi bi-clock-fill text-warning"></i> Working Hours</h5>
                    @if($currentSalon->default_open_time && $currentSalon->default_close_time)
                        <p class="text-muted mb-0">
                            <i class="bi bi-calendar-day"></i> 
                            {{ \Carbon\Carbon::parse($currentSalon->default_open_time)->format('g:i A') }} - 
                            {{ \Carbon\Carbon::parse($currentSalon->default_close_time)->format('g:i A') }}
                        </p>
                    @else
                        <p class="text-muted mb-2"><i class="bi bi-calendar-day"></i> Mon - Fri: 9:00 AM - 8:00 PM</p>
                        <p class="text-muted mb-2"><i class="bi bi-calendar-day"></i> Saturday: 10:00 AM - 6:00 PM</p>
                        <p class="text-muted mb-0"><i class="bi bi-calendar-day"></i> Sunday: Closed</p>
                    @endif
                </div>
            </div>

            <!-- Rating Card -->
            @if($currentSalon->reviews->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="display-3 fw-bold text-warning mb-2">
                        {{ number_format($currentSalon->reviews->avg('rating') ?? 0, 1) }}
                    </div>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($currentSalon->reviews->avg('rating')))
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted mb-0">Based on {{ $currentSalon->reviews->count() }} reviews</p>
                    <a href="{{ route('salon.reviews', $currentSalon->slug) }}" class="btn btn-sm btn-outline-warning mt-3">
                        View All Reviews
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
