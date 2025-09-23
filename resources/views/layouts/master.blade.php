<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-name" content="{{ Auth::user()->name }}">
        <meta name="user-email" content="{{ Auth::user()->email }}">
    @endauth

    <title>@yield('title', 'Sweet Delights Bakery')</title>
    <meta name="description" content="@yield('description', 'Sweet Delights Bakery - Artisanal pastries, fresh bread, and exceptional service.')">

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🥐</text></svg>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Sinhala:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/bakery-theme.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-bakery fixed-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-bakery" href="{{ route('home') }}">
                <i class="bi bi-shop me-2"></i>Sweet Delights
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-bakery {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-bakery {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">
                            <i class="bi bi-journal-text me-1"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-bakery {{ request()->routeIs('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">
                            <i class="bi bi-calendar-check me-1"></i>Reservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-bakery {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">
                            <i class="bi bi-newspaper me-1"></i>Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-bakery {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <!-- Cart Icon -->
                        <li class="nav-item me-3">
                            <button class="btn btn-outline-bakery position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-basket"></i>
                                <span class="cart-counter">0</span>
                            </button>
                        </li>

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-link-bakery" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">
                                    <i class="bi bi-receipt me-2"></i>My Orders
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.view') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a></li>
                                @if(Auth::user()->is_admin)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-check me-2"></i>Admin Panel
                                    </a></li>
                                @endif
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
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link nav-link-bakery" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-bakery" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-bakery">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">Sweet Delights Bakery</h5>
                    <p class="mb-3">Where every pastry tells a story of passion, quality, and exceptional taste. Experience the perfect blend of artisanal baking and warm hospitality.</p>
                    <div class="social-links d-flex gap-2">
                        <a href="#" class="social-link-bakery" data-coming-soon="Facebook page">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link-bakery" data-coming-soon="Instagram page">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link-bakery" data-coming-soon="Twitter page">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link-bakery" data-coming-soon="YouTube channel">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('reservation') }}">Reservations</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Contact Info</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-geo-alt me-2"></i>No.1, Mahamegawaththa Road, Maharagama</li>
                        <li><i class="bi bi-telephone me-2"></i>+94 77 186 9132</li>
                        <li><i class="bi bi-envelope me-2"></i>info@sweetdelights.lk</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>Business Hours</h6>
                    <ul class="list-unstyled">
                        <li>Monday - Friday: 6:00 AM - 10:00 PM</li>
                        <li>Saturday: 6:00 AM - 11:00 PM</li>
                        <li>Sunday: 7:00 AM - 10:00 PM</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 Sweet Delights Bakery. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#" class="me-3">Terms of Service</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Include Payment Modal -->
    @include('partials.payment-modal')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/simulation-payment.js') }}"></script>
    <script src="{{ asset('js/coming-soon.js') }}"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-bakery');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
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
                backdrop-filter: blur(10px);
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

        // Newsletter form submission
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForms = document.querySelectorAll('.newsletter-form');
            
            newsletterForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const email = this.querySelector('input[type="email"]').value;
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    if (!email) {
                        showNotification('Please enter your email address', 'warning');
                        return;
                    }

                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subscribing...';
                    submitBtn.disabled = true;

                    fetch('/newsletter/subscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Subscribed!';
                            submitBtn.classList.add('btn-success');
                            this.reset();
                            showNotification(data.message, 'success');
                        } else {
                            throw new Error(data.message || 'Subscription failed');
                        }
                    })
                    .catch(error => {
                        console.error('Newsletter subscription error:', error);
                        showNotification('Failed to subscribe. Please try again.', 'error');
                    })
                    .finally(() => {
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('btn-success');
                        }, 3000);
                    });
                });
            });

            // Contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!this.checkValidity()) {
                        this.classList.add('was-validated');
                        return;
                    }

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const btnLoading = submitBtn.querySelector('.btn-loading');

                    btnText.classList.add('d-none');
                    btnLoading.classList.remove('d-none');
                    submitBtn.disabled = true;

                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });

                    fetch('/contact', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(`Message sent successfully! Reference ID: ${data.message_id}`, 'success');
                            this.reset();
                            this.classList.remove('was-validated');
                        } else {
                            throw new Error(data.message || 'Failed to send message');
                        }
                    })
                    .catch(error => {
                        console.error('Contact form error:', error);
                        showNotification('Failed to send message. Please try again.', 'error');
                    })
                    .finally(() => {
                        btnText.classList.remove('d-none');
                        btnLoading.classList.add('d-none');
                        submitBtn.disabled = false;
                    });
                });
            }

            // Reservation form submission
            const reservationForm = document.getElementById('reservationForm');
            if (reservationForm) {
                reservationForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!this.checkValidity()) {
                        this.classList.add('was-validated');
                        return;
                    }

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const btnText = submitBtn.querySelector('.btn-text');
                    const btnLoading = submitBtn.querySelector('.btn-loading');

                    btnText.classList.add('d-none');
                    btnLoading.classList.remove('d-none');
                    submitBtn.disabled = true;

                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });

                    fetch('/reservation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(`Reservation confirmed! ID: ${data.reservation_id}`, 'success');
                            this.reset();
                            this.classList.remove('was-validated');
                        } else {
                            throw new Error(data.message || 'Failed to make reservation');
                        }
                    })
                    .catch(error => {
                        console.error('Reservation form error:', error);
                        showNotification('Failed to make reservation. Please try again.', 'error');
                    })
                    .finally(() => {
                        btnText.classList.remove('d-none');
                        btnLoading.classList.add('d-none');
                        submitBtn.disabled = false;
                    });
                });
            }
        });

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
            
            @keyframes blink {
                0%, 50% { opacity: 1; }
                51%, 100% { opacity: 0; }
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