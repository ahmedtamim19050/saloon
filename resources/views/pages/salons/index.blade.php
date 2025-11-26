@extends('layouts.app')

@section('title', 'Find Premium Salons')

@push('styles')
<style>
    /* Hero Section */
    .salons-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-1) 50%, var(--primary-2) 100%);
        padding: 5rem 0 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .salons-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.5;
    }
    
    .salons-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: var(--white);
    }
    
    .salons-hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        font-family: var(--font-heading);
        margin-bottom: 1rem;
        text-shadow: 2px 4px 12px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.8s ease-out;
    }
    
    .salons-hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }
    
    /* Search Section */
    .search-section {
        background: var(--white);
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-2xl);
        padding: 2rem;
        margin-top: -3rem;
        position: relative;
        z-index: 10;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }
    
    .search-input-group {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3.5rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 1.25rem;
    }
    
    .search-input:focus ~ .search-icon {
        color: var(--primary-2);
    }
    
    .filter-select {
        width: 100%;
        padding: 1rem 1rem 1rem 3.5rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-xl);
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
        cursor: pointer;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary-2);
        box-shadow: 0 0 0 4px rgba(190, 49, 68, 0.1);
    }
    
    .btn-search {
        width: 100%;
        padding: 1rem 2rem;
        background: var(--gradient-primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-xl);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(190, 49, 68, 0.3);
    }
    
    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(190, 49, 68, 0.4);
    }
    
    .btn-search:active {
        transform: translateY(0);
    }
    
    /* Stats Section */
    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .stat-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        text-align: center;
        border: 2px solid var(--gray-100);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        border-color: var(--primary-2);
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        font-family: var(--font-heading);
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--gray-600);
        font-size: 1rem;
    }
    
    /* Salon Cards */
    .salons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }
    
    .salon-card {
        background: var(--white);
        border-radius: var(--radius-2xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        animation: fadeInUp 0.6s ease-out both;
    }
    
    .salon-card:nth-child(1) { animation-delay: 0.1s; }
    .salon-card:nth-child(2) { animation-delay: 0.2s; }
    .salon-card:nth-child(3) { animation-delay: 0.3s; }
    .salon-card:nth-child(4) { animation-delay: 0.4s; }
    .salon-card:nth-child(5) { animation-delay: 0.5s; }
    .salon-card:nth-child(6) { animation-delay: 0.6s; }
    
    .salon-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--shadow-2xl);
    }
    
    .salon-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }
    
    .salon-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .salon-card:hover .salon-image {
        transform: scale(1.1);
    }
    
    .salon-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--gradient-coral);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        transition: transform 0.6s ease;
    }
    
    .salon-card:hover .salon-image-placeholder {
        transform: scale(1.1) rotate(5deg);
    }
    
    .salon-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--gradient-primary);
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: var(--shadow-lg);
        z-index: 2;
    }
    
    .salon-content {
        padding: 1.75rem;
    }
    
    .salon-name {
        font-size: 1.5rem;
        font-weight: 700;
        font-family: var(--font-heading);
        color: var(--primary-dark);
        margin-bottom: 0.75rem;
        transition: color 0.3s ease;
    }
    
    .salon-card:hover .salon-name {
        color: var(--primary-2);
    }
    
    .salon-location {
        display: flex;
        align-items: center;
        color: var(--gray-600);
        font-size: 0.9375rem;
        margin-bottom: 1rem;
        gap: 0.5rem;
    }
    
    .salon-location i {
        color: var(--primary-2);
        font-size: 1.125rem;
    }
    
    .salon-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.25rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--radius-lg);
    }
    
    .salon-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-700);
        font-size: 0.875rem;
    }
    
    .salon-meta-item i {
        color: var(--primary-2);
    }
    
    .salon-rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .salon-rating i {
        color: var(--warning);
        font-size: 1rem;
    }
    
    .btn-view-salon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.875rem 1.5rem;
        background: var(--gradient-primary);
        color: var(--white);
        text-decoration: none;
        border-radius: var(--radius-xl);
        font-weight: 600;
        transition: all 0.3s ease;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(190, 49, 68, 0.3);
    }
    
    .btn-view-salon:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(190, 49, 68, 0.4);
        color: var(--white);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .empty-icon {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }
    
    .empty-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.75rem;
    }
    
    .empty-text {
        font-size: 1.125rem;
        color: var(--gray-600);
    }
    
    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin: 3rem 0;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .salons-hero-title {
            font-size: 2.5rem;
        }
        
        .salons-hero {
            padding: 4rem 0 2rem;
        }
        
        .search-section {
            padding: 1.5rem;
            margin-top: -2rem;
        }
        
        .salons-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .salon-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="salons-hero">
    <div class="salons-hero-content">
        <div class="container">
            <h1 class="salons-hero-title">Discover Premium Salons</h1>
            <p class="salons-hero-subtitle">Find the perfect salon near you and book your appointment today</p>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="section-light" style="padding-top: 0;">
    <div class="container">
        <div class="search-section">
            <form method="GET" action="{{ route('salons.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="search-input-group">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search salons by name..." 
                                class="search-input"
                            >
                            <i class="bi bi-search search-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="search-input-group">
                            <select name="city" class="filter-select">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-geo-alt search-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-search">
                            <i class="bi bi-search"></i> Search Salons
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Stats -->
            <div class="stats-section">
                <div class="stat-card animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="stat-number">{{ $salons->total() }}</div>
                    <div class="stat-label">Premium Salons</div>
                </div>
                <div class="stat-card animate-fadeInUp" style="animation-delay: 0.3s;">
                    <div class="stat-number">{{ $cities->count() }}</div>
                    <div class="stat-label">Cities Covered</div>
                </div>
                <div class="stat-card animate-fadeInUp" style="animation-delay: 0.4s;">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Professional Barbers</div>
                </div>
                <div class="stat-card animate-fadeInUp" style="animation-delay: 0.5s;">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Salons Grid Section -->
<section class="section-light">
    <div class="container">
        @if($salons->count() > 0)
            <div class="section-header animate-fadeInUp">
                <h2 class="section-title mt-5">Featured Salons</h2>
                <p class="section-subtitle">Explore our handpicked selection of premium salons</p>
            </div>
            
            <div class="salons-grid">
                @foreach($salons as $index => $salon)
                    <div class="salon-card">
                        <div class="salon-image-wrapper">
                            @if($salon->cover_image)
                                <img src="{{ asset('storage/' . $salon->cover_image) }}" alt="{{ $salon->name }}" class="salon-image">
                            @elseif($salon->image)
                                <img src="{{ asset('storage/' . $salon->image) }}" alt="{{ $salon->name }}" class="salon-image">
                            @else
                                <div class="salon-image-placeholder">
                                    <i class="bi bi-scissors"></i>
                                </div>
                            @endif
                            
                            @if($salon->is_active)
                                <div class="salon-badge">
                                    <i class="bi bi-star-fill"></i> Premium
                                </div>
                            @endif
                        </div>
                        
                        <div class="salon-content">
                            <h3 class="salon-name">{{ $salon->name }}</h3>
                            
                            <div class="salon-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $salon->city }}, {{ $salon->state }}</span>
                            </div>
                            
                            <div class="salon-meta">
                                <div class="salon-meta-item">
                                    <i class="bi bi-people-fill"></i>
                                    <span>{{ $salon->providers_count }} {{ Illuminate\Support\Str::plural('Barber', $salon->providers_count) }}</span>
                                </div>
                                <div class="salon-meta-item">
                                    <div class="salon-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <span>4.8</span>
                                    </div>
                                </div>
                                <div class="salon-meta-item">
                                    <i class="bi bi-heart-fill"></i>
                                    <span>{{ $salon->followers_count ?? 0 }} Followers</span>
                                </div>
                            </div>
                            
                            @if($salon->hasSubdomain())
                                <a href="{{ $salon->subdomain_url }}" class="btn-view-salon" target="_blank">
                                    View Salon Profile
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            @else
                                <span class="text-muted small">Subdomain not available</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($salons->hasPages())
                <div class="pagination-wrapper">
                    {{ $salons->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3 class="empty-title">No Salons Found</h3>
                <p class="empty-text">Try adjusting your search criteria or explore all locations</p>
                <a href="{{ route('salons.index') }}" class="btn-primary" style="margin-top: 2rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-arrow-left"></i> View All Salons
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
