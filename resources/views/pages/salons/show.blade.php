@extends('layouts.app')

@section('title', $salon->name)

@push('styles')
<link href="{{ asset('css/home-sections.css') }}" rel="stylesheet">
<style>
    /* Salon Profile Styles - Facebook-like Design */
    .profile-cover {
        position: relative;
        height: 450px;
        background: var(--gradient-dark);
        overflow: hidden;
    }
    
    .profile-cover-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-header {
        position: relative;
        margin-top: -120px;
        z-index: 10;
    }
    
    .profile-info-wrapper {
        background: var(--white);
        border-radius: var(--radius-2xl);
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .profile-logo {
        width: 180px;
        height: 180px;
        border-radius: var(--radius-2xl);
        border: 6px solid var(--white);
        background: var(--white);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        object-fit: cover;
        margin-top: -90px;
    }
    
    .profile-logo-placeholder {
        width: 180px;
        height: 180px;
        border-radius: var(--radius-2xl);
        border: 6px solid var(--white);
        background: var(--gradient-coral);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 700;
        color: var(--white);
        margin-top: -90px;
    }
    
    .profile-name {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
        font-family: var(--font-heading);
    }
    
    .profile-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        color: var(--gray-600);
        font-size: 0.9375rem;
        margin-bottom: 1rem;
    }
    
    .profile-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .profile-social {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .profile-social-link {
        width: 42px;
        height: 42px;
        border-radius: var(--radius-lg);
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        font-size: 1.125rem;
        transition: all var(--transition-base);
        text-decoration: none;
    }
    
    .profile-social-link:hover {
        background: var(--gradient-coral);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }
    
    .profile-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-follow {
        padding: 0.75rem 2rem;
        font-weight: 600;
        font-size: 0.9375rem;
        border: none;
        border-radius: var(--radius-lg);
        color: var(--white);
        background: var(--gradient-coral);
        box-shadow: var(--shadow-glow);
        transition: all var(--transition-base);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-follow:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow-coral);
    }
    
    .btn-follow.following {
        background: var(--gray-600);
        box-shadow: none;
    }
    
    .btn-contact {
        padding: 0.75rem 2rem;
        font-weight: 600;
        font-size: 0.9375rem;
        border: 2px solid var(--primary-2);
        border-radius: var(--radius-lg);
        color: var(--primary-2);
        background: transparent;
        transition: all var(--transition-base);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .btn-contact:hover {
        background: var(--primary-2);
        color: var(--white);
        transform: translateY(-2px);
    }
    
    .profile-tabs {
        background: var(--white);
        border-radius: var(--radius-2xl);
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        margin-top: 2rem;
        overflow: hidden;
    }
    
    .profile-tabs-nav {
        display: flex;
        border-bottom: 2px solid var(--gray-200);
    }
    
    .profile-tab {
        flex: 1;
        padding: 1.25rem 1.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.9375rem;
        color: var(--gray-600);
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        transition: all var(--transition-base);
        position: relative;
    }
    
    .profile-tab:hover {
        color: var(--primary-2);
        background: var(--gray-50);
    }
    
    .profile-tab.active {
        color: var(--primary-2);
        border-bottom-color: var(--primary-2);
    }
    
    .profile-tab-content {
        padding: 2rem;
        display: none;
    }
    
    .profile-tab-content.active {
        display: block;
    }
    
    .profile-description {
        font-size: 1.0625rem;
        line-height: 1.8;
        color: var(--gray-700);
        margin-bottom: 2rem;
    }
    
    .profile-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .profile-stat-card {
        background: var(--gradient-coral);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        text-align: center;
        color: var(--white);
    }
    
    .profile-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        font-family: var(--font-heading);
        margin-bottom: 0.5rem;
    }
    
    .profile-stat-label {
        font-size: 0.9375rem;
        opacity: 0.9;
    }
    
    /* Hours Table Styles */
    .hours-table {
        width: 100%;
    }
    
    .hours-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .hours-row:last-child {
        border-bottom: none;
    }
    
    .hours-day {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 0.9375rem;
    }
    
    .hours-time {
        font-size: 0.875rem;
    }
    
    .hours-open {
        color: var(--success);
        font-weight: 500;
    }
    
    .hours-closed {
        color: var(--gray-500);
    }
    
    /* Review Avatar Styles */
    .review-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-coral);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        flex-shrink: 0;
    }
    
    .review-stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .review-star {
        font-size: 0.875rem;
    }
    
    .review-star.filled {
        color: var(--warning);
    }
    
    .review-star.empty {
        color: var(--gray-300);
    }
    
    @media (max-width: 768px) {
        .profile-cover {
            height: 300px;
        }
        
        .profile-logo,
        .profile-logo-placeholder {
            width: 120px;
            height: 120px;
            margin-top: -60px;
            font-size: 2.5rem;
        }
        
        .profile-name {
            font-size: 1.75rem;
        }
        
        .profile-tabs-nav {
            overflow-x: auto;
            flex-wrap: nowrap;
        }
        
        .profile-tab {
            flex: 0 0 auto;
            min-width: 120px;
        }
    }
    
    .info-card {
        background: var(--white);
        border-radius: var(--radius-2xl);
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .info-item {
        display: flex;
        gap: 1rem;
        padding: 1.25rem 0;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        background: linear-gradient(135deg, rgba(135, 35, 65, 0.1) 0%, rgba(190, 49, 68, 0.1) 100%);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-2);
        font-size: 1.25rem;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 0.9375rem;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        color: var(--gray-600);
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    
    .hours-table {
        width: 100%;
    }
    
    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: 0.625rem 0;
        font-size: 0.875rem;
    }
    
    .hours-day {
        color: var(--gray-600);
        font-weight: 500;
    }
    
    .hours-time {
        font-weight: 600;
    }
    
    .hours-open {
        color: var(--success);
    }
    
    .hours-closed {
        color: var(--danger);
    }
    
    .review-avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 50%;
        background: var(--gradient-coral);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--white);
        font-size: 1.125rem;
    }
    
    .review-stars {
        display: flex;
        gap: 0.25rem;
    }
    
    .review-star {
        font-size: 0.875rem;
    }
    
    .review-star.filled {
        color: var(--warning);
    }
    
    .review-star.empty {
        color: var(--gray-300);
    }
</style>
@endpush

@section('content')
<!-- Profile Cover Image -->
<div class="profile-cover">
    @if($salon->cover_image)
        <img src="{{ asset('storage/' . $salon->cover_image) }}" alt="{{ $salon->name }} Cover" class="profile-cover-image">
    @else
        <div style="width: 100%; height: 100%; background: var(--gradient-dark); position: relative;">
            <div style="position: absolute; inset: 0; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 600 600&quot;><filter id=&quot;noiseFilter&quot;><feTurbulence type=&quot;fractalNoise&quot; baseFrequency=&quot;0.9&quot; numOctaves=&quot;4&quot; stitchTiles=&quot;stitch&quot;/></filter><rect width=&quot;100%&quot; height=&quot;100%&quot; filter=&quot;url(%23noiseFilter)&quot; opacity=&quot;0.05&quot;/></svg>'); opacity: 0.3;"></div>
        </div>
    @endif
</div>

<!-- Profile Header -->
<section class="section-light" style="padding-top: 0;">
    <div class="container">
        <div class="profile-header">
            <div class="profile-info-wrapper">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-start gap-4 flex-wrap">
                            <!-- Logo -->
                            @if($salon->logo)
                                <img src="{{ asset('storage/' . $salon->logo) }}" alt="{{ $salon->name }}" class="profile-logo">
                            @else
                                <div class="profile-logo-placeholder">
                                    {{ strtoupper(substr($salon->name, 0, 2)) }}
                                </div>
                            @endif
                            
                            <!-- Info -->
                            <div style="flex: 1; min-width: 250px;">
                                <h1 class="profile-name">{{ $salon->name }}</h1>
                                
                                <div class="profile-meta">
                                    <div class="profile-meta-item">
                                        <i class="bi bi-geo-alt-fill" style="color: var(--primary-3);"></i>
                                        <span>{{ $salon->city }}, {{ $salon->state }}</span>
                                    </div>
                                    <div class="profile-meta-item">
                                        <i class="bi bi-people-fill" style="color: var(--primary-3);"></i>
                                        <span>{{ number_format($salon->followers_count) }} followers</span>
                                    </div>
                                    <div class="profile-meta-item">
                                        <i class="bi bi-star-fill" style="color: var(--warning);"></i>
                                        <span>4.8 rating</span>
                                    </div>
                                </div>
                                
                                <p style="color: var(--gray-600); font-size: 0.9375rem; line-height: 1.7; margin-bottom: 1rem;">
                                    {{ $salon->description }}
                                </p>
                                
                                <!-- Social Links -->
                                @if($salon->facebook || $salon->instagram || $salon->twitter || $salon->linkedin || $salon->youtube || $salon->website)
                                    <div class="profile-social">
                                        @if($salon->facebook)
                                            <a href="{{ $salon->facebook }}" target="_blank" class="profile-social-link" title="Facebook">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        @endif
                                        @if($salon->instagram)
                                            <a href="{{ $salon->instagram }}" target="_blank" class="profile-social-link" title="Instagram">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        @endif
                                        @if($salon->twitter)
                                            <a href="{{ $salon->twitter }}" target="_blank" class="profile-social-link" title="Twitter">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        @endif
                                        @if($salon->linkedin)
                                            <a href="{{ $salon->linkedin }}" target="_blank" class="profile-social-link" title="LinkedIn">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        @endif
                                        @if($salon->youtube)
                                            <a href="{{ $salon->youtube }}" target="_blank" class="profile-social-link" title="YouTube">
                                                <i class="bi bi-youtube"></i>
                                            </a>
                                        @endif
                                        @if($salon->website)
                                            <a href="{{ $salon->website }}" target="_blank" class="profile-social-link" title="Website">
                                                <i class="bi bi-globe"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="profile-actions" style="justify-content: flex-end; margin-top: 1rem;">
                            <button class="btn-follow" onclick="toggleFollow(this)">
                                <i class="bi bi-plus-circle"></i>
                                Follow
                            </button>
                            <a href="#contact" class="btn-contact">
                                <i class="bi bi-chat-dots"></i>
                                Contact
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tab Navigation -->
            <div class="profile-tabs">
                <div class="profile-tabs-nav">
                    <button class="profile-tab active" onclick="openTab(event, 'about')">
                        <i class="bi bi-info-circle"></i> About
                    </button>
                    <button class="profile-tab" onclick="openTab(event, 'team')">
                        <i class="bi bi-people"></i> Team ({{ $salon->providers->count() }})
                    </button>
                    <button class="profile-tab" onclick="openTab(event, 'services')">
                        <i class="bi bi-scissors"></i> Services
                    </button>
                    <button class="profile-tab" onclick="openTab(event, 'reviews')">
                        <i class="bi bi-star"></i> Reviews ({{ $salon->reviews()->count() }})
                    </button>
                    <button class="profile-tab" onclick="openTab(event, 'contact')">
                        <i class="bi bi-telephone"></i> Contact
                    </button>
                </div>
                
                <!-- About Tab -->
                <div id="about" class="profile-tab-content active">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">
                        <i class="bi bi-building"></i> About {{ $salon->name }}
                    </h2>
                    
                    <div class="profile-description">
                        {{ $salon->full_description ??$salon->description ?? 'Welcome to our premium salon. We provide exceptional grooming services delivered by experienced professionals in a comfortable and luxurious environment.' }}
                    </div>
                    
                    <!-- Stats -->
                    <div class="profile-stats">
                        <div class="profile-stat-card">
                            <div class="profile-stat-number">{{ $salon->providers->count() }}</div>
                            <div class="profile-stat-label">Professional Barbers</div>
                        </div>
                        <div class="profile-stat-card" style="background: var(--gradient-primary);">
                            <div class="profile-stat-number">{{ $salon->reviews()->count() }}</div>
                            <div class="profile-stat-label">Customer Reviews</div>
                        </div>
                        <div class="profile-stat-card" style="background: linear-gradient(135deg, var(--success) 0%, #059669 100%);">
                            <div class="profile-stat-number">{{ number_format($salon->followers_count) }}</div>
                            <div class="profile-stat-label">Followers</div>
                        </div>
                        @php
                            $serviceCount = $salon->providers->flatMap->services->unique('id')->count();
                        @endphp
                        <div class="profile-stat-card" style="background: linear-gradient(135deg, var(--warning) 0%, #F59E0B 100%);">
                            <div class="profile-stat-number">{{ $serviceCount }}</div>
                            <div class="profile-stat-label">Services Offered</div>
                        </div>
                    </div>
                    
                    <!-- Quick Info -->
                    <div class="row" style="margin-top: 2rem;">
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-geo-alt-fill" style="color: var(--primary-2);"></i> Location
                                </h3>
                                <p style="color: var(--gray-600); line-height: 1.8;">
                                    {{ $salon->address }}<br>
                                    {{ $salon->city }}, {{ $salon->state }}<br>
                                    @if($salon->zip_code) {{ $salon->zip_code }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-clock-fill" style="color: var(--primary-2);"></i> Working Hours
                                </h3>
                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    $workingDays = array_map('strtolower', $salon->working_days ?? []);
                                @endphp
                                <div class="hours-table">
                                    @foreach($days as $day)
                                        <div class="hours-row">
                                            <span class="hours-day">{{ $day }}</span>
                                            @if(in_array(strtolower($day), $workingDays))
                                                <span class="hours-time hours-open">
                                                    {{ \Carbon\Carbon::parse($salon->opening_time)->format('g:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($salon->closing_time)->format('g:i A') }}
                                                </span>
                                            @else
                                                <span class="hours-time hours-closed">Closed</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Team Tab -->
                <div id="team" class="profile-tab-content">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">
                        <i class="bi bi-people"></i> Our Professional Team
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 2rem;">Meet our skilled barbers and stylists</p>
                    
                    <div class="row">
                        @foreach($salon->providers as $provider)
                            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                                <div class="provider-card">
                                    <div class="provider-avatar">
                                        @if($provider->photo)
                                            <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->user->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($provider->user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <h3 class="provider-name">{{ $provider->user->name }}</h3>
                                    <p class="provider-specialty">Professional Barber</p>
                                    <div class="provider-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <span>{{ $provider->rating ?? '4.9' }}</span>
                                        <span>•</span>
                                        <span>{{ $provider->appointments_count ?? '150' }}+ clients</span>
                                    </div>
                                    <a href="{{ route('providers.show', $provider) }}" class="btn-provider">
                                        <i class="bi bi-calendar-check"></i> Book Appointment
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Services Tab -->
                <div id="services" class="profile-tab-content">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">
                        <i class="bi bi-scissors"></i> Services & Pricing
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 2rem;">Professional grooming services tailored to your needs</p>
                    
                    <div class="row">
                        @php
                            $uniqueServices = $salon->providers->flatMap->services->unique('id');
                        @endphp
                        @foreach($uniqueServices as $service)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="service-card">
                                    <div class="service-icon">
                                        <i class="bi bi-scissors"></i>
                                    </div>
                                    <h3 class="service-name">{{ $service->name }}</h3>
                                    <p class="service-price">৳{{ number_format($service->price, 0) }}</p>
                                    <p class="service-description">
                                        {{ $service->description ?? 'Professional service delivered by expert stylists' }}
                                    </p>
                                    <a href="#team" onclick="openTab(event, 'team')" class="btn-service">
                                        Book Now <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div id="reviews" class="profile-tab-content">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">
                        <i class="bi bi-star"></i> Customer Reviews
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 2rem;">Read what our clients say about their experience</p>
                    
                    @php
                        $allReviews = $salon->reviews()->with('user')->latest()->get();
                    @endphp

                    @if($allReviews->count() > 0)
                        <div class="row">
                            @foreach($allReviews as $review)
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="service-card" style="border-left-color: var(--primary-3); height: 100%;">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="review-avatar" style="margin-right: 1rem;">
                                                {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: var(--primary-dark); font-size: 1rem;">
                                                    {{ $review->user->name }}
                                                </div>
                                                <div class="review-stars" style="margin-top: 0.25rem;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star-fill review-star {{ $i <= $review->rating ? 'filled' : 'empty' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <p style="color: var(--gray-600); font-size: 0.9375rem; line-height: 1.7; margin: 0 0 1rem 0;">
                                            "{{ $review->comment }}"
                                        </p>
                                        <div style="font-size: 0.8125rem; color: var(--gray-500);">
                                            {{ $review->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="service-card" style="text-align: center; padding: 3rem 2rem;">
                            <div style="font-size: 4rem; color: var(--gray-400); margin-bottom: 1rem;">
                                <i class="bi bi-chat-quote"></i>
                            </div>
                            <h3 style="color: var(--gray-600); font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">No Reviews Yet</h3>
                            <p style="color: var(--gray-500); font-size: 1rem;">Be the first to share your experience!</p>
                        </div>
                    @endif
                </div>
                
                <!-- Contact Tab -->
                <div id="contact" class="profile-tab-content">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">
                        <i class="bi bi-telephone"></i> Contact Information
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 2rem;">Get in touch with us</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-telephone-fill" style="color: var(--primary-2);"></i> Phone
                                </h3>
                                <p style="color: var(--gray-600); font-size: 1.125rem; margin-bottom: 0.5rem;">
                                    <a href="tel:{{ $salon->phone }}" style="color: var(--primary-2); text-decoration: none;">
                                        {{ $salon->phone }}
                                    </a>
                                </p>
                                <p style="color: var(--gray-500); font-size: 0.875rem;">Call us for appointments</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-envelope-fill" style="color: var(--primary-2);"></i> Email
                                </h3>
                                <p style="color: var(--gray-600); font-size: 1.125rem; margin-bottom: 0.5rem;">
                                    <a href="mailto:{{ $salon->email }}" style="color: var(--primary-2); text-decoration: none;">
                                        {{ $salon->email }}
                                    </a>
                                </p>
                                <p style="color: var(--gray-500); font-size: 0.875rem;">Send us a message</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-geo-alt-fill" style="color: var(--primary-2);"></i> Address
                                </h3>
                                <p style="color: var(--gray-600); line-height: 1.8;">
                                    {{ $salon->address }}<br>
                                    {{ $salon->city }}, {{ $salon->state }}<br>
                                    @if($salon->zip_code) {{ $salon->zip_code }} @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                                    <i class="bi bi-clock-fill" style="color: var(--primary-2);"></i> Business Hours
                                </h3>
                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    $workingDays = array_map('strtolower', $salon->working_days ?? []);
                                @endphp
                                <div class="hours-table">
                                    @foreach($days as $day)
                                        <div class="hours-row">
                            <span class="hours-day">{{ $day }}</span>
                                            @if(in_array(strtolower($day), $workingDays))
                                                <span class="hours-time hours-open">
                                                    {{ \Carbon\Carbon::parse($salon->opening_time)->format('g:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($salon->closing_time)->format('g:i A') }}
                                                </span>
                                            @else
                                                <span class="hours-time hours-closed">Closed</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function openTab(evt, tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.profile-tab-content');
    tabContents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.profile-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    evt.currentTarget.classList.add('active');
    
    // Smooth scroll to tabs
    document.querySelector('.profile-tabs').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function toggleFollow(button) {
    // Toggle following state
    button.classList.toggle('following');
    
    // Update button text
    if (button.classList.contains('following')) {
        button.innerHTML = '<i class="bi bi-check-circle-fill"></i> Following';
    } else {
        button.innerHTML = '<i class="bi bi-plus-circle"></i> Follow';
    }
    
    // TODO: Send AJAX request to backend to update follow status
    // Example:
    // fetch('/salons/{{ $salon->id }}/follow', {
    //     method: 'POST',
    //     headers: {
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    //         'Content-Type': 'application/json'
    //     }
    // }).then(response => response.json())
    //   .then(data => console.log(data));
}
</script>
@endpush


        </div>
    </div>
</section>
@endsection
