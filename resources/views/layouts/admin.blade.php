<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Café Elixir')</title>

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --bakery-primary: #8B4513;
            --bakery-secondary: #D2691E;
            --bakery-accent: #CD853F;
            --bakery-warm: #F4E4BC;
            --bakery-cream: #FFF8DC;
            --bakery-brown: #654321;
            --bakery-pink: #DEB887;
            --bakery-gradient: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #CD853F 100%);
            --bakery-shadow: 0 8px 32px rgba(139, 69, 19, 0.15);
            --bakery-shadow-hover: 0 12px 40px rgba(139, 69, 19, 0.25);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FFF8DC 0%, #F4E4BC 100%);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--bakery-brown);
        }

        .sidebar {
            background: var(--bakery-gradient);
            box-shadow: 4px 0 20px rgba(139, 69, 19, 0.2);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1.5" fill="rgba(255,255,255,0.15)"/><circle cx="80" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1.2" fill="rgba(255,255,255,0.12)"/><circle cx="60" cy="50" r="0.8" fill="rgba(255,255,255,0.08)"/></svg>') repeat;
            opacity: 0.4;
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 2rem 1.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
        }

        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand h4 i {
            font-size: 2rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-top: 0.5rem;
            display: block;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 2;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 1rem 1.5rem;
            margin: 0.5rem 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            backdrop-filter: blur(15px);
            border: 2px solid transparent;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: all 0.6s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: white !important;
            transform: translateX(8px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link i {
            width: 24px;
            margin-right: 1rem;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .nav-link:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #FFF8DC 0%, #F4E4BC 50%, #FFF8DC 100%);
            position: relative;
        }

        .main-content::before {
            content: '';
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="50" cy="50" r="2" fill="rgba(139,69,19,0.03)"/><circle cx="150" cy="80" r="1.5" fill="rgba(210,105,30,0.02)"/><circle cx="100" cy="150" r="1.8" fill="rgba(205,133,63,0.025)"/></svg>') repeat;
            opacity: 0.6;
            pointer-events: none;
            z-index: -1;
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 3px solid var(--bakery-primary);
            padding: 1.25rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--bakery-shadow);
        }

        .content-area {
            padding: 2.5rem;
            position: relative;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            transition: all 0.3s ease;
            background: var(--bakery-gradient);
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.15) rotate(10deg);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
        }

        .btn-bakery {
            background: var(--bakery-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: var(--bakery-shadow);
            position: relative;
            overflow: hidden;
        }

        .btn-bakery::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s;
        }

        .btn-bakery:hover::before {
            left: 100%;
        }

        .btn-bakery:hover {
            transform: translateY(-3px);
            box-shadow: var(--bakery-shadow-hover);
            color: white;
        }

        .stat-card {
            transition: all 0.3s ease;
            border: 2px solid rgba(139, 69, 19, 0.1);
            position: relative;
            overflow: hidden;
            background: white;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(139, 69, 19, 0.08), transparent);
            transition: all 0.6s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--bakery-shadow-hover) !important;
            border-color: var(--bakery-primary);
        }

        .text-bakery {
            color: var(--bakery-primary) !important;
        }

        .text-gray-800 {
            color: var(--bakery-brown) !important;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--bakery-shadow);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--bakery-shadow-hover);
        }

        .card-header {
            background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
            border-bottom: 2px solid rgba(139, 69, 19, 0.1);
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table th {
            background: linear-gradient(45deg, rgba(139, 69, 19, 0.08), rgba(210, 105, 30, 0.08));
            border: none;
            color: var(--bakery-brown);
            font-weight: 600;
            padding: 1rem;
        }

        .table td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid rgba(139, 69, 19, 0.05);
        }

        .table tbody tr:hover {
            background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        }

        .btn-outline-bakery {
            border: 2px solid var(--bakery-primary);
            color: var(--bakery-primary);
            background: transparent;
            font-weight: 600;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .btn-outline-bakery:hover {
            background: var(--bakery-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        }

        .badge {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }

        .bg-bakery {
            background: var(--bakery-gradient) !important;
        }

        .form-control, .form-select {
            border: 2px solid rgba(139, 69, 19, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--bakery-primary);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
            transform: translateY(-1px);
        }

        /* Real-time indicators */
        .live-indicator {
            position: relative;
        }

        .live-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -15px;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: livePulse 2s infinite;
        }

        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        /* Enhanced notification styles */
        .notification-toast {
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
        }

        /* Chart container fixes */
        .card-body {
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .card-body canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Ensure charts are properly sized */
        .chart-container {
            min-height: 350px;
            width: 100%;
            height: 300px;
        }

        /* Modern dropdown styles */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: var(--bakery-shadow);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .dropdown-item {
            border-radius: 10px;
            margin: 0.25rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(45deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
            color: var(--bakery-brown);
            transform: translateX(5px);
        }

        /* Enhanced button styles */
        .btn {
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-group .btn {
            border-radius: 8px;
        }

        /* Page header styles */
        .page-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 2px solid rgba(139, 69, 19, 0.1);
        }

        .page-header h1 {
            color: var(--bakery-brown);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content::before {
                left: 0;
            }

            .chart-container {
                height: 250px;
            }

            .content-area {
                padding: 1.5rem;
            }

            .top-navbar {
                padding: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">

            .content-area {
                padding: 1rem;
            }

            .top-navbar {
                padding: 0.75rem 1rem;
            }
            <h4>
                <i class="bi bi-shop"></i>
                Sweet Delights
            </h4>
            <small class="text-white-50">Admin Dashboard</small>
        </div>

        <ul class="sidebar-nav list-unstyled">
            <li>
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}" 
                   href="{{ route('admin.reservations') }}">
                    <i class="bi bi-calendar-check"></i>
                    Reservations
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders') }}">
                    <i class="bi bi-receipt"></i>
                    Orders
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" 
                   href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i>
                    Products
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                   href="{{ route('admin.users') }}">
                    <i class="bi bi-people"></i>
                    Users
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.menu*') ? 'active' : '' }}" 
                   href="{{ route('admin.menu') }}">
                    <i class="bi bi-journal-text"></i>
                    Menu Management
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.profile-requests*') ? 'active' : '' }}" 
                   href="{{ route('admin.profile-requests.index') }}">
                    <i class="bi bi-person-gear"></i>
                    Profile Changes
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.reservation-requests*') ? 'active' : '' }}" 
                   href="{{ route('admin.reservation-requests.index') }}">
                    <i class="bi bi-pencil-square"></i>
                    Reservation Changes
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.analytics*') ? 'active' : '' }}" 
                   href="{{ route('admin.analytics') }}">
                    <i class="bi bi-graph-up"></i>
                    Analytics
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings') }}">
                    <i class="bi bi-gear"></i>
                    Settings
                </a>
            </li>
        </ul>

        <div class="mt-auto p-4">
            <div class="d-grid">
                <a href="{{ route('home') }}" class="btn btn-outline-light">
                    <i class="bi bi-house me-2"></i>Back to Website
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-secondary d-md-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="btn btn-outline-bakery position-relative" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#">New reservation request</a></li>
                            <li><a class="dropdown-item" href="#">Order #CE001 completed</a></li>
                            <li><a class="dropdown-item" href="#">New user registered</a></li>
                        </ul>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-bakery dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Global notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} position-fixed notification-toast`;
            notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 350px;
                border-radius: 15px;
                animation: slideInRight 0.5s ease;
                box-shadow: var(--bakery-shadow);
            `;

            const iconMap = {
                'success': 'check-circle-fill',
                'error': 'exclamation-triangle-fill',
                'warning': 'exclamation-triangle-fill',
                'info': 'info-circle-fill'
            };

            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-${iconMap[type]} me-2"></i>
                    <span class="flex-grow-1">${message}</span>
                    <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);
        }

        // CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            
            .notification-toast {
                backdrop-filter: blur(10px);
            }
        `;
        document.head.appendChild(style);
    </script>

    @stack('scripts')
</body>
</html>