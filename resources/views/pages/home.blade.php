@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<link href="{{ asset('css/home-sections.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Premium Hero Section -->
<div class="hero-section animate-fadeIn">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title animate-fadeInUp">
                <span class="font-script" style="font-size: 1.2em; color: var(--barber-coral);">The Fyna</span><br>
                Barber's House
            </h1>
            <p class="hero-subtitle animate-fadeInUp" style="animation-delay: 0.2s;">
                Experience authentic style where tradition meets modern grooming excellence
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap animate-fadeInUp" style="animation-delay: 0.4s;">
                <a href="{{ route('salons.index') }}" class="btn btn-white btn-lg">
                    <i class="bi bi-scissors"></i> Browse Salons
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline btn-lg" style="border-color: white; color: white;">
                        <i class="bi bi-person-plus"></i> Get Started
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Premium Features Section -->
<section class="section-light">
    <div class="container">
        <div class="section-header animate-fadeInUp">
            <h2 class="section-title">Why Choose Us</h2>
            <p class="section-subtitle">Authentic style • Made your appointment • Get me in 5 min now</p>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-4 mb-4 animate-fadeInUp">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h3 class="feature-title">Easy Booking</h3>
                    <p class="feature-description">Schedule your appointment online in seconds. Choose your preferred time and professional.</p>
                </div>
            </div>
            
            <div class="col-12 col-md-4 mb-4 animate-fadeInUp" style="animation-delay: 0.1s;">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h3 class="feature-title">Top Professionals</h3>
                    <p class="feature-description">Verified experts with years of experience and stellar customer reviews.</p>
                </div>
            </div>
            
            <div class="col-12 col-md-4 mb-4 animate-fadeInUp" style="animation-delay: 0.2s;">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="feature-title">Secure Payments</h3>
                    <p class="feature-description">Safe and flexible payment options after your service is complete.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Featured Salons Section -->
@if($salons->count() > 0)
<section class="section-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <h2 class="section-title mb-2" style="text-align: left;">Featured Salons</h2>
                <p class="section-subtitle" style="text-align: left;">Discover our premium partner locations</p>
            </div>
            <a href="{{ route('salons.index') }}" class="btn-outline" style="border-color: var(--primary-2); color: var(--primary-2);">
                View All Salons <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="row">
            @foreach($salons as $salon)
                <div class="col-12 col-md-6 col-lg-4 mb-4 animate-fadeInUp">
                    <div class="salon-card">
                        <div class="salon-card-image">
                            <i class="bi bi-building"></i>
                            <div class="salon-badge">Premium</div>
                        </div>
                        <div class="salon-card-body">
                            <h3 class="salon-name">{{ $salon->name }}</h3>
                            <div class="salon-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $salon->city }}, {{ $salon->state }}</span>
                            </div>
                            <div class="salon-stats">
                                <div class="salon-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>4.8</span>
                                </div>
                                <span class="salon-meta">{{ $salon->providers_count }} professionals</span>
                            </div>
                            @if($salon->hasSubdomain())
                                <a href="{{ $salon->subdomain_url }}" class="btn-salon" target="_blank">
                                    View Salon <i class="bi bi-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Premium Services Section -->


<!-- Premium CTA Section -->
<section class="cta-section">
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-7 text-center text-lg-start mb-4 mb-lg-0 animate-fadeInLeft">
                <div class="cta-badge">
                    <i class="bi bi-gift-fill"></i>
                    Special Weekend Offer
                </div>
                <h2 class="cta-title mb-3">Get 20% Off<br>Every Sunday</h2>
                <p style="font-size: 1.25rem; color: var(--gray-300); margin-bottom: 2rem; line-height: 1.8;">
                    Join thousands of satisfied customers who trust us<br class="d-lg-block"> for their grooming needs. Book now and save!
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-start flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn-white btn-lg">
                            <i class="bi bi-person-plus"></i> Create Free Account
                        </a>
                    @else
                        <a href="{{ route('salons.index') }}" class="btn-white btn-lg">
                            <i class="bi bi-calendar-check"></i> Book Appointment
                        </a>
                    @endguest
                    <a href="{{ route('salons.index') }}" class="btn-outline btn-lg" style="border-color: white; color: white;">
                        <i class="bi bi-search"></i> Browse Salons
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center animate-fadeInRight">
                <div class="cta-discount-badge">
                    <div style="text-align: center; color: var(--white);">
                        <p style="font-size: 4rem; font-weight: 700; line-height: 1; margin: 0; font-family: var(--font-heading);">20%</p>
                        <p style="font-size: 1.5rem; font-weight: 600; opacity: 0.95; margin: 0.5rem 0;">OFF</p>
                        <p style="font-size: 1rem; opacity: 0.85; margin: 0;">Every Sunday</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
