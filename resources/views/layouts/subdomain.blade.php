@php
    // Get currentSalon from view data or from subdomain
    if (!isset($currentSalon)) {
        $host = request()->getHost();
        $hostParts = explode('.', $host);
        
        if (count($hostParts) >= 3) {
            $salonSlug = $hostParts[0];
            $currentSalon = \App\Models\Salon::where('slug', $salonSlug)
                ->with(['providers.user'])
                ->first();
        } else {
            $currentSalon = null;
        }
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $currentSalon->name ?? config('app.name'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        /* Subdomain Header Styles - Dark Blue Theme */
        .subdomain-header {
            background: linear-gradient(135deg, rgba(9, 18, 44, 0.98) 0%, rgba(9, 18, 44, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        
        .subdomain-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }
        
        .subdomain-logo-img {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            object-fit: cover;
        }
        
        .subdomain-logo-placeholder {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            background: var(--gradient-coral);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--white);
            font-size: 1.25rem;
        }
        
        .subdomain-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            font-family: var(--font-heading);
        }
        
        .subdomain-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .subdomain-nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            position: relative;
        }
        
        .subdomain-nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }
        
        .subdomain-nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .subdomain-nav-link:hover::before {
            width: 60%;
        }
        
        .subdomain-nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }
        
        .subdomain-nav-link.active::before {
            width: 60%;
        }
        
        .subdomain-btn-book {
            padding: 0.625rem 1.5rem;
            background: white;
            color: #872341;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            transition: all var(--transition-base);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .subdomain-btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 255, 255, 0.3);
            background: #f8f9fa;
            color: #872341;
        }
        
        /* Mobile Menu */
        .subdomain-mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }
        
        @media (max-width: 991px) {
            .subdomain-nav {
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
                flex-direction: column;
                padding: 1.5rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
                display: none;
                gap: 1rem;
            }
            
            .subdomain-nav.active {
                display: flex;
            }
            
            .subdomain-mobile-toggle {
                display: block;
            }
        }
        
        /* Subdomain Footer Styles - Dark Blue Theme */
        .subdomain-footer {
            background: linear-gradient(135deg, rgba(9, 18, 44, 0.98) 0%, rgba(9, 18, 44, 0.95) 100%);
            color: var(--white);
            padding: 4rem 0 1.5rem;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .subdomain-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.5;
        }
        
        .subdomain-footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .subdomain-footer-logo-img {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            object-fit: cover;
        }
        
        .subdomain-footer-logo-placeholder {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            background: var(--gradient-coral);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--white);
            font-size: 1.5rem;
        }
        
        .subdomain-footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: var(--font-heading);
        }
        
        .subdomain-footer-section-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--white);
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .subdomain-footer-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
            border-radius: 2px;
        }
        
        .subdomain-footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.875rem;
            transition: all var(--transition-base);
            font-size: 0.9375rem;
        }
        
        .subdomain-footer-link::before {
            content: '→';
            opacity: 0;
            transform: translateX(-10px);
            transition: all var(--transition-base);
        }
        
        .subdomain-footer-link:hover {
            color: var(--white);
            padding-left: 0.5rem;
        }
        
        .subdomain-footer-link:hover::before {
            opacity: 1;
            transform: translateX(0);
        }
        
        .subdomain-footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .subdomain-footer-social-link {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.125rem;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .subdomain-footer-social-link:hover {
            background: linear-gradient(135deg, #872341 0%, #BE3144 100%);
            color: white;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 20px rgba(190, 49, 68, 0.4);
            border-color: transparent;
        }
        
        .subdomain-footer-content {
            position: relative;
            z-index: 1;
        }
        
        .subdomain-footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 3rem;
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }
        
        .subdomain-footer-info {
            display: flex;
            align-items: start;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .subdomain-footer-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .subdomain-footer-info p,
        .subdomain-footer-info a {
            margin: 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9375rem;
            line-height: 1.6;
        }
        
        .subdomain-footer-info a:hover {
            color: white;
        }
        
        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-on-scroll.animate-fade-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Active navigation link highlighting */
        .subdomain-nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 18px;
        }
        
        .user-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.05);
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            overflow: hidden;
        }
        
        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 12px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
        }
        
        .user-dropdown-header {
            padding: 16px;
            background: linear-gradient(135deg, #872341, #BE3144);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-dropdown-header-name {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 2px;
        }
        
        .user-dropdown-header-email {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .user-dropdown-item:last-child {
            border-bottom: none;
        }
        
        .user-dropdown-item:hover {
            background: #f9fafb;
            color: #872341;
            padding-left: 20px;
        }
        
        .user-dropdown-item i {
            font-size: 16px;
            width: 20px;
        }
        
        @media (max-width: 991px) {
            .user-dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                margin-top: 10px;
            }
            
            .user-dropdown-menu::before {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="subdomain-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <a href="/" class="subdomain-logo">
                    @if($currentSalon && $currentSalon->logo)
                        <img src="{{ asset('storage/' . $currentSalon->logo) }}" alt="{{ $currentSalon->name }}" class="subdomain-logo-img">
                    @elseif($currentSalon)
                        <div class="subdomain-logo-placeholder">
                            {{ strtoupper(substr($currentSalon->name, 0, 2)) }}
                        </div>
                    @endif
                    <span class="subdomain-logo-text">{{ $currentSalon->name ?? config('app.name') }}</span>
                </a>
             
                
                <!-- Desktop Navigation -->
                <nav class="subdomain-nav" id="subdomainNav">
                    <a href="/" class="subdomain-nav-link">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                    <a href="#team" class="subdomain-nav-link smooth-scroll">
                        <i class="bi bi-people"></i> Our Team
                    </a>
                    <a href="#services" class="subdomain-nav-link smooth-scroll">
                        <i class="bi bi-scissors"></i> Services
                    </a>
                    <a href="#reviews" class="subdomain-nav-link smooth-scroll">
                        <i class="bi bi-star"></i> Reviews
                    </a>
                    <a href="#contact" class="subdomain-nav-link smooth-scroll">
                        <i class="bi bi-telephone"></i> Contact
                    </a>
                    
                    @guest
                        <div class="user-dropdown" id="guestDropdown">
                            <button class="user-dropdown-toggle" type="button" id="guestDropdownToggle">
                                <i class="bi bi-person"></i>
                            </button>
                            <div class="user-dropdown-menu" id="guestDropdownMenu">
                                <a href="{{ route('login') }}" class="user-dropdown-item">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    <span>Login</span>
                                </a>
                                <a href="{{ route('register') }}" class="user-dropdown-item">
                                    <i class="bi bi-person-plus"></i>
                                    <span>Register</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="user-dropdown" id="userDropdown">
                            <button class="user-dropdown-toggle" type="button" id="userDropdownToggle">
                                <i class="bi bi-person-fill"></i>
                            </button>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <div class="user-dropdown-header">
                                    <div class="user-dropdown-header-name">{{ auth()->user()->name }}</div>
                                    <div class="user-dropdown-header-email">{{ auth()->user()->email }}</div>
                                </div>
                                @if(auth()->user()->role?->name === 'customer')
                                    <a href="{{ route('customer.dashboard') }}" class="user-dropdown-item">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('customer.appointments') }}" class="user-dropdown-item">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>My Appointments</span>
                                    </a>
                                    <a href="{{ route('customer.profile') }}" class="user-dropdown-item">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Profile</span>
                                    </a>
                                @elseif(auth()->user()->role?->name === 'provider')
                                    <a href="{{ route('provider.dashboard') }}" class="user-dropdown-item">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('provider.appointments') }}" class="user-dropdown-item">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>Appointments</span>
                                    </a>
                                    <a href="{{ route('provider.profile') }}" class="user-dropdown-item">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Profile</span>
                                    </a>
                                @elseif(auth()->user()->role?->name === 'salon')
                                    <a href="{{ route('salon.dashboard') }}" class="user-dropdown-item">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('salon.providers') }}" class="user-dropdown-item">
                                        <i class="bi bi-people"></i>
                                        <span>Providers</span>
                                    </a>
                                    <a href="{{ route('salon.profile') }}" class="user-dropdown-item">
                                        <i class="bi bi-building"></i>
                                        <span>Salon Profile</span>
                                    </a>
                                @else
                                    <a href="/admin" class="user-dropdown-item">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Admin Panel</span>
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; font-size: 14px;">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                    
                    <a href="{{ route('appointments.book') }}" class="subdomain-btn-book">
                        <i class="bi bi-calendar-check"></i> Book Now
                    </a>
                </nav>
                
                <!-- Mobile Toggle -->
                <button class="subdomain-mobile-toggle" id="mobileToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="subdomain-footer">
        <div class="container subdomain-footer-content">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 mb-4">
                    @if($currentSalon)
                        <div class="subdomain-footer-logo">
                            @if($currentSalon->logo)
                                <img src="{{ asset('storage/' . $currentSalon->logo) }}" alt="{{ $currentSalon->name }}" class="subdomain-footer-logo-img">
                            @else
                                <div class="subdomain-footer-logo-placeholder text-white">
                                    {{ strtoupper(substr($currentSalon->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="subdomain-footer-title text-white">{{ $currentSalon->name }}</span>
                        </div>
                        <p style="color: rgba(255, 255, 255, 0.7); line-height: 1.8; font-size: 0.9375rem; margin-bottom: 2rem;">
                            {{ $currentSalon->description ?? 'Your premier destination for professional grooming and styling services.' }}
                        </p>
                    @else
                        <div class="subdomain-footer-logo">
                            <span class="subdomain-footer-title text-white">{{ config('app.name') }}</span>
                        </div>
                        <p style="color: rgba(255, 255, 255, 0.7); line-height: 1.8; font-size: 0.9375rem; margin-bottom: 2rem;">
                            Your premier destination for professional grooming and styling services.
                        </p>
                    @endif
                    
                    <!-- Social Links -->
                    @if($currentSalon && ($currentSalon->facebook || $currentSalon->instagram || $currentSalon->twitter || $currentSalon->linkedin || $currentSalon->youtube))
                        <div class="subdomain-footer-social">
                            @if($currentSalon->facebook)
                                <a href="{{ $currentSalon->facebook }}" target="_blank" class="subdomain-footer-social-link" title="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if($currentSalon->instagram)
                                <a href="{{ $currentSalon->instagram }}" target="_blank" class="subdomain-footer-social-link" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if($currentSalon->twitter)
                                <a href="{{ $currentSalon->twitter }}" target="_blank" class="subdomain-footer-social-link" title="Twitter">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endif
                            @if($currentSalon->linkedin)
                                <a href="{{ $currentSalon->linkedin }}" target="_blank" class="subdomain-footer-social-link" title="LinkedIn">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                            @if($currentSalon->youtube)
                                <a href="{{ $currentSalon->youtube }}" target="_blank" class="subdomain-footer-social-link" title="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4 mb-4">
                    <h3 class="subdomain-footer-section-title text-white">Quick Links</h3>
                    <a href="/" class="subdomain-footer-link">Home</a>
                    <a href="/teams" class="subdomain-footer-link">Our Team</a>
                    <a href="/services" class="subdomain-footer-link">Services</a>
                    <a href="/reviews" class="subdomain-footer-link">Reviews</a>
                    <a href="/book" class="subdomain-footer-link">Book Appointment</a>
                </div>
               
            
                <!-- Services -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <h3 class="subdomain-footer-section-title text-white">Our Services</h3>
                    @php
                        $footerServices = $currentSalon->providers->flatMap->services->unique('id')->take(5);
                    @endphp
                    @foreach($footerServices as $service)
                        <a href="/services" class="subdomain-footer-link">{{ $service->name }}</a>
                    @endforeach
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <h3 class="subdomain-footer-section-title text-white">Contact Us</h3>
                    
                    <div class="subdomain-footer-info">
                        <div class="subdomain-footer-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 0.9375rem; line-height: 1.6;">
                                {{ $currentSalon->address }}<br>
                                {{ $currentSalon->city }}, {{ $currentSalon->state }}
                                @if($currentSalon->zip_code) {{ $currentSalon->zip_code }} @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="subdomain-footer-info">
                        <div class="subdomain-footer-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <a href="tel:{{ $currentSalon->phone }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.9375rem;">
                                {{ $currentSalon->phone }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="subdomain-footer-info">
                        <div class="subdomain-footer-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <a href="mailto:{{ $currentSalon->email }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.9375rem;">
                                {{ $currentSalon->email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="subdomain-footer-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <p style="margin: 0; color: rgba(255, 255, 255, 0.5);">
                        &copy; {{ date('Y') }} {{ $currentSalon->name }}. All rights reserved. Powered by <strong style="color: rgba(255, 255, 255, 0.7);">{{ config('app.name', 'Saloon') }}</strong>
                    </p>
                    <div class="d-flex gap-3" style="font-size: 0.875rem;">
                        <a href="#privacy" style="color: rgba(255, 255, 255, 0.5); text-decoration: none; transition: color 0.3s;">Privacy</a>
                        <a href="#terms" style="color: rgba(255, 255, 255, 0.5); text-decoration: none; transition: color 0.3s;">Terms</a>
                        <a href="#cookies" style="color: rgba(255, 255, 255, 0.5); text-decoration: none; transition: color 0.3s;">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Menu Toggle & Smooth Scroll -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('subdomainNav').classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-list');
            icon.classList.toggle('bi-x');
        });
        
        // User dropdown toggle (for authenticated users)
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userDropdownToggle && userDropdown) {
            userDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        }
        
        // Guest dropdown toggle (for guest users)
        const guestDropdownToggle = document.getElementById('guestDropdownToggle');
        const guestDropdown = document.getElementById('guestDropdown');
        
        if (guestDropdownToggle && guestDropdown) {
            guestDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                guestDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!guestDropdown.contains(e.target)) {
                    guestDropdown.classList.remove('active');
                }
            });
        }
        
        // Smooth scroll for bookmark links
        document.querySelectorAll('.smooth-scroll').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                // If section exists on current page, smooth scroll to it
                if (targetSection) {
                    e.preventDefault();
                    const headerHeight = 80;
                    const targetPosition = targetSection.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    document.getElementById('subdomainNav').classList.remove('active');
                    document.getElementById('mobileToggle').querySelector('i').classList.add('bi-list');
                    document.getElementById('mobileToggle').querySelector('i').classList.remove('bi-x');
                    
                    // Update active link
                    document.querySelectorAll('.smooth-scroll').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                } else {
                    // If section doesn't exist, navigate to home page with anchor
                    const currentHost = window.location.host;
                    const protocol = window.location.protocol;
                    window.location.href = protocol + '//' + currentHost + '/' + targetId;
                }
            });
        });
        
        // Intersection Observer for scroll spy
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '-80px 0px -50% 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    document.querySelectorAll('.smooth-scroll').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }, observerOptions);
        
        // Observe all sections
        document.querySelectorAll('[id]').forEach(section => {
            if (['about', 'team', 'services', 'reviews', 'contact'].includes(section.id)) {
                observer.observe(section);
            }
        });
        
        // Fade-in animations on scroll
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            fadeObserver.observe(el);
        });
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
