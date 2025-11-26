<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $currentSalon->name)</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/home-sections.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #BE3144;
            --primary-dark: #872341;
            --primary-1: #872341;
            --primary-2: #BE3144;
            --gradient-coral: linear-gradient(135deg, #872341 0%, #BE3144 100%);
            --gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 24px;
            --font-heading: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --transition-base: all 0.3s ease;
            --shadow-glow: 0 8px 24px rgba(190, 49, 68, 0.25);
        }
        
        body {
            font-family: var(--font-heading);
            background: var(--gray-50);
            color: var(--gray-700);
        }
        
        /* Profile Cover */
        .profile-cover {
            position: relative;
            height: 350px;
            background: var(--gradient-dark);
            overflow: hidden;
        }
        
        .profile-cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Profile Header */
        .profile-header {
            position: relative;
            margin-top: -100px;
            z-index: 10;
        }
        
        .profile-info-wrapper {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .profile-logo {
            width: 140px;
            height: 140px;
            border-radius: var(--radius-2xl);
            border: 6px solid var(--white);
            background: var(--white);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            object-fit: cover;
            margin-top: -70px;
        }
        
        .profile-logo-placeholder {
            width: 140px;
            height: 140px;
            border-radius: var(--radius-2xl);
            border: 6px solid var(--white);
            background: var(--gradient-coral);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: var(--white);
            margin-top: -70px;
        }
        
        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
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
            transition: var(--transition-base);
            text-decoration: none;
        }
        
        .profile-social-link:hover {
            background: var(--gradient-coral);
            color: var(--white);
            transform: translateY(-3px);
        }
        
        /* Tab Navigation */
        .profile-tabs {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-top: 2rem;
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .profile-tabs-nav {
            display: flex;
            border-bottom: 2px solid var(--gray-200);
            overflow-x: auto;
        }
        
        .profile-tab {
            flex: 1;
            padding: 1rem 1.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--gray-600);
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            transition: var(--transition-base);
            text-decoration: none;
            display: block;
            min-width: 120px;
        }
        
        .profile-tab:hover {
            color: var(--primary-2);
            background: var(--gray-50);
        }
        
        .profile-tab.active {
            color: var(--primary-2);
            border-bottom-color: var(--primary-2);
        }
        
        .book-now-tab {
            background: var(--gradient-coral) !important;
            color: white !important;
            margin-left: auto;
        }
        
        .book-now-tab:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }
        
        /* Footer */
        .salon-footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
        .salon-footer h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .salon-footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .salon-footer a:hover {
            color: white;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .profile-cover { height: 250px; }
            .profile-logo, .profile-logo-placeholder {
                width: 100px;
                height: 100px;
                margin-top: -50px;
                font-size: 2rem;
            }
            .profile-name { font-size: 1.5rem; }
            .profile-tabs-nav { flex-wrap: nowrap; }
            .profile-tab { flex: 0 0 auto; }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Profile Cover -->
    <div class="profile-cover">
        @if($currentSalon->cover_image)
            <img src="{{ asset('storage/' . $currentSalon->cover_image) }}" alt="{{ $currentSalon->name }} Cover" class="profile-cover-image">
        @else
            <div style="width: 100%; height: 100%; background: var(--gradient-dark); position: relative;">
                <div style="position: absolute; inset: 0; opacity: 0.3;"></div>
            </div>
        @endif
    </div>
    
    <!-- Profile Header -->
    <section class="pb-4" style="padding-top: 0;">
        <div class="container">
            <div class="profile-header">
                <div class="profile-info-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-start gap-4 flex-wrap">
                                <!-- Logo -->
                                @if($currentSalon->logo)
                                    <img src="{{ asset('storage/' . $currentSalon->logo) }}" alt="{{ $currentSalon->name }}" class="profile-logo">
                                @else
                                    <div class="profile-logo-placeholder">
                                        {{ strtoupper(substr($currentSalon->name, 0, 2)) }}
                                    </div>
                                @endif
                                
                                <!-- Info -->
                                <div style="flex: 1; min-width: 250px;">
                                    <h1 class="profile-name">{{ $currentSalon->name }}</h1>
                                    
                                    <div class="profile-meta">
                                        <div>
                                            <i class="bi bi-geo-alt-fill" style="color: var(--primary-2);"></i>
                                            {{ $currentSalon->city ?? 'Location' }}
                                        </div>
                                        <div>
                                            <i class="bi bi-star-fill" style="color: var(--warning);"></i>
                                            {{ number_format($currentSalon->reviews->avg('rating') ?? 0, 1) }}
                                        </div>
                                        <div>
                                            <i class="bi bi-people-fill" style="color: var(--primary-2);"></i>
                                            {{ $currentSalon->followers_count }} followers
                                        </div>
                                    </div>
                                    
                                    <p style="color: var(--gray-600); font-size: 0.9375rem; margin-bottom: 1rem;">
                                        {{ $currentSalon->description }}
                                    </p>
                                    
                                    <!-- Social Links -->
                                    @if($currentSalon->facebook || $currentSalon->instagram || $currentSalon->twitter)
                                        <div class="profile-social">
                                            @if($currentSalon->facebook)
                                                <a href="{{ $currentSalon->facebook }}" target="_blank" class="profile-social-link">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                            @endif
                                            @if($currentSalon->instagram)
                                                <a href="{{ $currentSalon->instagram }}" target="_blank" class="profile-social-link">
                                                    <i class="bi bi-instagram"></i>
                                                </a>
                                            @endif
                                            @if($currentSalon->twitter)
                                                <a href="{{ $currentSalon->twitter }}" target="_blank" class="profile-social-link">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="profile-tabs">
                    <div class="profile-tabs-nav">
                        <a href="{{ route('salon.home', $currentSalon->slug) }}" class="profile-tab {{ request()->routeIs('salon.home') ? 'active' : '' }}">
                            <i class="bi bi-info-circle"></i> About
                        </a>
                        <a href="{{ route('salon.teams', $currentSalon->slug) }}" class="profile-tab {{ request()->routeIs('salon.teams*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Team ({{ $currentSalon->providers->count() }})
                        </a>
                        <a href="{{ route('salon.services', $currentSalon->slug) }}" class="profile-tab {{ request()->routeIs('salon.services') ? 'active' : '' }}">
                            <i class="bi bi-scissors"></i> Services
                        </a>
                        <a href="{{ route('salon.reviews', $currentSalon->slug) }}" class="profile-tab {{ request()->routeIs('salon.reviews') ? 'active' : '' }}">
                            <i class="bi bi-star"></i> Reviews ({{ $currentSalon->reviews->count() }})
                        </a>
                        <a href="{{ route('salon.contact', $currentSalon->slug) }}" class="profile-tab {{ request()->routeIs('salon.contact') ? 'active' : '' }}">
                            <i class="bi bi-telephone"></i> Contact
                        </a>
                        <a href="{{ route('salon.book', $currentSalon->slug) }}" class="profile-tab book-now-tab">
                            <i class="bi bi-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Salon Footer -->
    <footer class="salon-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-building"></i> {{ $currentSalon->name }}</h5>
                    <p>{{ $currentSalon->description }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-info-circle"></i> Contact Info</h5>
                    <p>
                        <i class="bi bi-geo-alt"></i> {{ $currentSalon->address }}<br>
                        <i class="bi bi-telephone"></i> {{ $currentSalon->phone }}<br>
                        <i class="bi bi-envelope"></i> {{ $currentSalon->email }}
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-share"></i> Follow Us</h5>
                    <div class="social-links">
                        @if($currentSalon->facebook)
                            <a href="{{ $currentSalon->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if($currentSalon->instagram)
                            <a href="{{ $currentSalon->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if($currentSalon->twitter)
                            <a href="{{ $currentSalon->twitter }}" target="_blank"><i class="bi bi-twitter"></i></a>
                        @endif
                        @if($currentSalon->linkedin)
                            <a href="{{ $currentSalon->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $currentSalon->name }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
