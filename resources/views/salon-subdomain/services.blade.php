@extends('salon-subdomain.layout')

@section('title', 'Services - ' . $currentSalon->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h2><i class="bi bi-scissors text-primary"></i> Our Services</h2>
            <p class="text-muted">Discover our range of professional services</p>
        </div>
    </div>

    @if($currentSalon->services->count() > 0)
        <div class="row g-4">
            @foreach($currentSalon->services->groupBy('category') as $category => $services)
                <div class="col-12">
                    <h4 class="mb-3 text-primary">{{ $category ?? 'General Services' }}</h4>
                </div>
                @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="flex: 1;">
                                    <h5 class="mb-1">{{ $service->name }}</h5>
                                    @if($service->description)
                                        <p class="text-muted small mb-0">{{ Str::limit($service->description, 100) }}</p>
                                    @endif
                                </div>
                                <div class="ms-2">
                                    <i class="bi bi-scissors fs-3 text-primary"></i>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">
                                        <i class="bi bi-clock text-muted"></i>
                                        <span class="text-muted small">{{ $service->duration }} min</span>
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-person text-muted"></i>
                                        <span class="text-muted small">{{ $service->provider->user->name ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h4 class="mb-0 text-primary">{{ Settings::formatPrice($service->price) }}</h4>
                                </div>
                            </div>
                            
                            <a href="{{ route('salon.book', $currentSalon->slug) }}" 
                               class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-calendar-check"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
    @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h5>No Services Available</h5>
                <p class="mb-0">Check back soon for our services!</p>
            </div>
        </div>
    @endif
</div>
@endsection
