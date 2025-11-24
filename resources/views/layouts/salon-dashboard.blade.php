<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-dark: #09122C;
            --primary-1: #872341;
            --primary-2: #BE3144;
            --primary-3: #E17564;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* ============================================
           DARK SIDEBAR LAYOUT
           ============================================ */
        .salon-dashboard-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Dark Sidebar */
        .salon-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, #0d1936 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .salon-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .salon-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        /* Sidebar Header - Cover Image */
        .sidebar-cover {
            position: relative;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-1) 0%, var(--primary-2) 100%);
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .sidebar-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(9, 18, 44, 0.8) 100%);
        }

        .sidebar-cover-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.05) 10px, rgba(255,255,255,.05) 20px);
        }

        /* Salon Logo & Info */
        .salon-info {
            position: relative;
            padding: 20px;
            margin-top: -75px;
            z-index: 2;
        }

        .salon-logo-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: white;
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .salon-logo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            background: linear-gradient(135deg, var(--primary-2), var(--primary-3));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            font-weight: 600;
        }

        .salon-logo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .salon-name {
            text-align: center;
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .salon-role {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            font-weight: 400;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 24px 0 12px;
            padding: 0 12px;
        }

        .nav-section-title:first-child {
            margin-top: 0;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin-bottom: 4px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--primary-2);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-link-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .nav-link-item:hover::before {
            transform: scaleY(1);
        }

        .nav-link-item.active {
            background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
            color: white;
            box-shadow: 0 4px 12px rgba(190, 49, 68, 0.3);
        }

        .nav-link-item.active::before {
            transform: scaleY(1);
        }

        .nav-link-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .nav-link-badge {
            margin-left: auto;
            background: var(--primary-2);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .user-profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .user-profile-card:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-2), var(--primary-3));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            color: white;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-logout {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            transition: color 0.3s ease;
        }

        .user-logout:hover {
            color: var(--primary-3);
        }

        /* Main Content Area */
        .salon-main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* Top Header */
        .salon-header {
            height: var(--header-height);
            background: linear-gradient(135deg, var(--primary-dark) 0%, #0d1936 100%);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 24px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-action-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-action-btn:hover {
            background: var(--primary-2);
            color: white;
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--primary-2);
            color: white;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary-dark);
        }

        /* Content Area */
        .salon-content {
            flex: 1;
            padding: 32px;
            background: #f8f9fa;
        }

        /* Alerts */
        .alert-modern {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .alert-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .salon-sidebar {
                transform: translateX(-100%);
            }

            .salon-sidebar.active {
                transform: translateX(0);
            }

            .salon-main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .salon-header {
                padding: 0 16px;
            }

            .salon-content {
                padding: 20px 16px;
            }

            .page-title {
                font-size: 20px;
            }
        }

        @media (max-width: 575px) {
            :root {
                --sidebar-width: 100%;
            }

            .salon-content {
                padding: 16px 12px;
            }

            .header-actions {
                gap: 8px;
            }
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="salon-dashboard-wrapper">
        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Dark Sidebar Component -->
        <x-salon-sidebar :salon="$salon" :userRole="$userRole ?? 'Salon Owner'"/>

        <!-- Main Content -->
        <div class="salon-main-content">
            <!-- Top Header -->
            <header class="salon-header">
                <div class="header-left">
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="page-title">@yield('header', 'Dashboard')</h1>
                </div>
                <div class="header-actions">
                    @yield('header-actions')
                    <button class="header-action-btn" title="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="header-action-btn" title="Settings">
                        <i class="bi bi-gear"></i>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <main class="salon-content">
                @if(session('success'))
                    <div class="alert-modern alert-success">
                        <i class="bi bi-check-circle-fill alert-icon"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-modern alert-error">
                        <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const salonSidebar = document.getElementById('salonSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            salonSidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        mobileMenuBtn?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        // Close sidebar on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && salonSidebar.classList.contains('active')) {
                toggleSidebar();
            }
        });

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-modern');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
