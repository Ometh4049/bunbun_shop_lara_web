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
            --bakery-primary: #D4A574;
            --bakery-secondary: #F4E4C1;
            --bakery-accent: #E8B4B8;
            --bakery-warm: #F7E7CE;
            --bakery-cream: #FFF8E7;
            --bakery-brown: #8B6F47;
            --bakery-pink: #F5D5D0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--bakery-primary), var(--bakery-secondary));
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.3;
            pointer-events: none;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .sidebar-nav {
            padding: 1rem 0;
            position: relative;
            z-index: 2;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            backdrop-filter: blur(10px);
            border: 1px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.2);
            color: white !important;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .top-navbar {
            background: white;
            border-bottom: 2px solid var(--bakery-primary);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .content-area {
            padding: 2rem;
            position: relative;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-bakery {
            background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        .btn-bakery:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 165, 116, 0.4);
            color: white;
        }

        .stat-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 165, 116, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 165, 116, 0.1), transparent);
            transition: all 0.6s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(212, 165, 116, 0.2) !important;
        }

        .text-bakery {
            color: var(--bakery-primary) !important;
        }

        .text-gray-800 {
            color: #2d3748 !important;
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
        }

        /* Chart container fixes */
        .card-body {
            position: relative;
            overflow: hidden;
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

            .chart-container {
                height: 250px;
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
            <h4><i class="bi bi-shop me-2"></i>Sweet Delights</h4>
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

        <div class="mt-auto p-3">
            <div class="d-grid">
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
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
                        <button class="btn btn-outline-secondary position-relative" data-bs-toggle="dropdown">
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

    <!-- Pusher for real-time updates (optional) -->
    <!-- Pusher for real-time updates (optional) -->
    <!-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> -->

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
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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