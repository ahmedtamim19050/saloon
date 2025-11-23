<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Provider Dashboard' }} - {{ config('app.name') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom Theme CSS -->
    <link href="{{ asset('css/saloon-theme.css') }}" rel="stylesheet">
    
    <style>
        .sidebar {
            background-color: var(--white);
            min-height: calc(100vh - 56px);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 56px;
        }
        .sidebar .list-group-item {
            border: none;
            border-radius: var(--radius-md);
            margin-bottom: 0.25rem;
            transition: all var(--transition-base);
        }
        .sidebar .list-group-item:hover {
            background-color: var(--light-gray);
            transform: translateX(5px);
        }
        .sidebar .list-group-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
        }
        .sidebar .list-group-item a {
            color: inherit;
            text-decoration: none;
            display: block;
        }
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important;
            box-shadow: var(--shadow-md);
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: static;
                min-height: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('provider.dashboard') }}">
                <i class="bi bi-calendar-check me-2"></i>Provider Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('provider.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('provider.settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar - col-md-3 -->
            <div class="col-md-3 col-lg-2 p-0">
                <nav class="sidebar p-3">
                    <div class="mb-3">
                        <h6 class="text-muted text-uppercase fw-bold small">Menu</h6>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('provider.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->routeIs('provider.bookings.*') ? 'active' : '' }}">
                            <a href="{{ route('provider.bookings.index') }}">
                                <i class="bi bi-calendar-check me-2"></i>Appointments
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->routeIs('provider.schedule') ? 'active' : '' }}">
                            <a href="#" onclick="alert('Schedule page coming soon'); return false;">
                                <i class="bi bi-clock me-2"></i>Schedule
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->routeIs('provider.wallet.*') ? 'active' : '' }}">
                            <a href="{{ route('provider.wallet.index') }}">
                                <i class="bi bi-wallet2 me-2"></i>Wallet
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->routeIs('provider.reviews.*') ? 'active' : '' }}">
                            <a href="{{ route('provider.reviews.index') }}">
                                <i class="bi bi-star me-2"></i>Reviews
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->routeIs('provider.settings') ? 'active' : '' }}">
                            <a href="{{ route('provider.settings') }}">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                        </li>
                    </ul>

                    <!-- Sidebar Footer -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <strong>{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</strong>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 small">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">Provider</small>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Main Content - col-md-9 -->
            <main class="col-md-9 col-lg-10 px-md-4 py-4 main-content">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
