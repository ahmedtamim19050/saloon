@extends('salon-subdomain.layout')

@section('title', 'Our Team - ' . $currentSalon->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h2><i class="bi bi-people-fill text-primary"></i> Our Professional Team</h2>
            <p class="text-muted">Meet our talented providers</p>
        </div>
    </div>

    @if($currentSalon->providers->count() > 0)
        <div class="row g-4">
            @foreach($currentSalon->providers as $provider)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        @if($provider->user && $provider->user->image)
                            <img src="{{ asset('storage/' . $provider->user->image) }}" 
                                 alt="{{ $provider->user->name }}" 
                                 class="rounded-circle mb-3" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--primary-color);">
                        @else
                            <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 120px; height: 120px; background: var(--gradient-coral); color: white; font-size: 2.5rem; font-weight: 700; border: 4px solid var(--primary-color);">
                                {{ strtoupper(substr($provider->user->name ?? 'P', 0, 1)) }}
                            </div>
                        @endif
                        
                        <h5 class="mb-1">{{ $provider->user->name ?? 'Provider' }}</h5>
                        <p class="text-muted small mb-2">{{ $provider->specialization ?? 'Specialist' }}</p>
                        
                        <div class="mb-3">
                            @php
                                $avgRating = $provider->reviews->avg('rating') ?? 0;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($avgRating))
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="text-muted small">({{ $provider->reviews->count() }})</span>
                        </div>
                        
                        <p class="text-muted small mb-3">
                            <i class="bi bi-scissors"></i> {{ $provider->services->count() }} Services
                        </p>
                        
                        <a href="{{ route('salon.teams.show', [$currentSalon->slug, $provider->id]) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> View Profile
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h5>No Team Members Yet</h5>
                <p class="mb-0">Check back soon!</p>
            </div>
        </div>
    @endif
</div>
@endsection
