<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - ITLAB</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --admin-primary: #1d1e27;
            --admin-secondary: #04aa6d;
            --admin-bg: #f5f5f5;
            --admin-card: #ffffff;
            --admin-text: #333;
            --admin-border: #e0e0e0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Source Sans 3", system-ui, -apple-system, sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: var(--admin-primary);
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            /* Ensure sidebar is always visible on desktop */
            transform: translateX(0);
        }

        .admin-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .admin-sidebar-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .admin-sidebar-header .logo {
            color: var(--admin-secondary);
            font-weight: bold;
        }

        .admin-nav {
            padding: 10px 0;
        }

        .admin-nav-item {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s;
        }

        .admin-nav-item:hover,
        .admin-nav-item.active {
            background: rgba(255,255,255,0.1);
        }

        .admin-nav-item i {
            width: 20px;
            margin-left: 10px;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .admin-header {
            background: var(--admin-card);
            padding: 20px 30px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-content {
            padding: 30px;
        }

        /* Cards */
        .admin-card {
            background: var(--admin-card);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-card-header h2 {
            margin: 0;
            font-size: 18px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--admin-secondary);
            color: #000;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #038a5a;
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table th {
            background: var(--admin-bg);
            font-weight: 600;
        }

        .admin-table tr:hover {
            background: var(--admin-bg);
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--admin-border);
            border-radius: 5px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--admin-secondary);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--admin-card);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: var(--admin-secondary);
        }

        /* Mobile Menu Toggle Button */
        .admin-menu-toggle {
            display: none;
            background: var(--admin-primary);
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-left: 15px;
        }

        .admin-menu-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-menu-toggle {
                display: inline-block;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Ensure sidebar is always visible on desktop and tablets */
        @media (min-width: 769px) {
            .admin-sidebar {
                transform: translateX(0) !important;
                position: fixed !important;
                left: 0 !important;
            }
            
            .admin-sidebar.active {
                transform: translateX(0) !important;
            }
        }

            .admin-header {
                padding: 15px 20px;
            }

            .admin-header h1 {
                font-size: 20px;
            }

            .admin-content {
                padding: 20px 15px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card .stat-value {
                font-size: 24px;
            }

            .admin-table {
                font-size: 14px;
            }

            .admin-table th,
            .admin-table td {
                padding: 8px;
            }

            .admin-card {
                padding: 15px;
            }

            .admin-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .admin-card-header h2 {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .admin-header {
                padding: 12px 15px;
                flex-wrap: wrap;
            }

            .admin-header h1 {
                font-size: 18px;
            }

            .admin-user {
                font-size: 14px;
            }

            .admin-content {
                padding: 15px 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .admin-table {
                font-size: 12px;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .btn {
                padding: 8px 15px;
                font-size: 12px;
            }
        }

        /* Overlay for mobile sidebar */
        .admin-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .admin-sidebar-overlay.active {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <h2><span class="logo">IT</span> LAB Admin</h2>
            </div>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.tracks.index') }}" class="admin-nav-item {{ request()->routeIs('admin.tracks.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    Tracks
                </a>
                <a href="{{ route('admin.pages.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    Pages
                </a>
                <a href="{{ route('admin.navbar.index') }}" class="admin-nav-item {{ request()->routeIs('admin.navbar.*') ? 'active' : '' }}">
                    <i class="fas fa-bars"></i>
                    Navbar
                </a>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Users
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="admin-nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i>
                    Certificates
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    Contacts
                    @php
                        try {
                            $unreadCount = \App\Models\Contact::unread()->count();
                        } catch (\Exception $e) {
                            $unreadCount = 0;
                        }
                    @endphp
                    @if($unreadCount > 0)
                        <span style="background: var(--admin-secondary); color: #000; padding: 2px 6px; border-radius: 10px; font-size: 11px; margin-right: 5px;">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.stats.index') }}" class="admin-nav-item {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Statistics
                </a>
                <a href="{{ route('admin.reports.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    Reports
                </a>
                <a href="{{ route('admin.home-background.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.home-background.*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    Home Background
                </a>
                <a href="{{ route('home') }}" class="admin-nav-item">
                    <i class="fas fa-globe"></i>
                    Main Site
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" style="margin: 20px;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button class="admin-menu-toggle" id="menuToggle" aria-label="Toggle menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="admin-user">
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                </div>
            </header>

            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-right: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Check if we're on mobile
            const isMobile = window.innerWidth <= 768;
            
            // On desktop/tablet, always keep sidebar visible
            if (!isMobile) {
                if (sidebar) {
                    sidebar.classList.add('active');
                }
            }

            if (menuToggle && sidebar && overlay) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', function() {
                    // Only close on mobile
                    if (isMobile) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });

                // Keep sidebar open when clicking nav items on desktop
                const navItems = sidebar.querySelectorAll('.admin-nav-item');
                navItems.forEach(function(item) {
                    item.addEventListener('click', function() {
                        // On desktop, keep sidebar open
                        if (!isMobile) {
                            sidebar.classList.add('active');
                        }
                        // On mobile, you can optionally keep it open or close it
                        // Uncomment the next line if you want to close sidebar on mobile after clicking
                        // else { sidebar.classList.remove('active'); overlay.classList.remove('active'); }
                    });
                });

                // Handle window resize
                window.addEventListener('resize', function() {
                    const currentIsMobile = window.innerWidth <= 768;
                    if (!currentIsMobile && sidebar) {
                        sidebar.classList.add('active');
                        overlay.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html>

