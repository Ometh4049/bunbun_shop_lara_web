@extends('layouts.master')

@section('title', 'Sweet Delights Bakery - Home')
@section('description', 'Welcome to Sweet Delights Bakery. Experience artisanal pastries, fresh bread, and exceptional service.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-up">
                    <h1 class="hero-title">Welcome to Sweet Delights Bakery</h1>
                    <p class="hero-subtitle">Where every pastry tells a story of passion, quality, and exceptional taste. Experience the perfect blend of artisanal baking and warm hospitality.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('menu') }}" class="btn btn-bakery btn-lg">
                            <i class="bi bi-journal-text me-2"></i>View Pastries
                        </a>
                        <a href="{{ route('reservation') }}" class="btn btn-outline-bakery btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Make Reservation
                        </a>
                    </div>
                    <div class="text-center mt-5 mb-4">
                        <p id="sinhalaTypewriter" style="font-size: 1.3rem; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); font-weight: 500; min-height: 2em; font-family: 'Noto Sans Sinhala', serif; display: inline;">
                        </p>
                        <span id="cursor" style="color: #fff; font-size: 20px; animation: blink 1s infinite;">|</span>
                    </div>
                    <div class="text-center mt-2 mb-2">
                        <p id="englishTypewriter" style="font-size: 1.3rem; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); font-weight: 500; min-height: 2em; font-family: 'Noto Sans Sinhala', serif; display: inline;">
                        </p>
                        <span id="cursor" style="color: #fff; font-size: 20px; animation: blink 1s infinite;">|</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=650&h=650&fit=crop"
                         alt="Fresh Pastries"
                         class="img-fluid rounded-circle floating"
                         style="max-width: 650px; box-shadow: 10px 90px 90px rgba(0,0,0,0.3);margin-top:50px:">

                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="text-center position-absolute bottom-0 start-50 translate-middle-x mb-4">
        <a href="#features" class="text-white text-decoration-none">
            <i class="bi bi-chevron-down fs-2" style="animation: bounce 2s infinite;"></i>
        </a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-bakery mb-3">Why Choose Sweet Delights?</h2>
                <p class="lead text-muted">We're passionate about delivering exceptional baking experiences that delight your taste buds</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-cake2"></i>
                    </div>
                    <h4 class="mb-3">Artisanal Pastries</h4>
                    <p class="text-muted">Crafted daily with the finest ingredients and traditional techniques, ensuring every bite delivers exceptional flavor and texture that pastry lovers crave.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <h4 class="mb-3">Master Bakers</h4>
                    <p class="text-muted">Our skilled and passionate bakers craft each pastry with precision, artistry, and love, creating the perfect treat tailored to your taste preferences.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h4 class="mb-3">Cozy Atmosphere</h4>
                    <p class="text-muted">Relax in our warm, welcoming space designed for comfort - perfect for work, study, meetings, or simply enjoying quality time with friends and family.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h4 class="mb-3">Extended Hours</h4>
                    <p class="text-muted">Open early and staying late to serve your bakery needs from sunrise to sunset. Whether you're an early bird or night owl, we're here for you.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <h4 class="mb-3">Fresh Coffee & Tea</h4>
                    <p class="text-muted">Complement your pastries with our selection of premium coffee and tea. Perfect pairings to enhance your bakery experience.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="mb-3">Community Focus</h4>
                    <p class="text-muted">More than just coffee - we're a community hub where neighbors become friends, ideas flourish, and memories are made over great conversations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-bakery mb-3">Featured Bakery Selection</h2>
                <p class="lead text-muted">Discover our most beloved pastry creations, baked with passion and served with pride</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $index => $product)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card card-bakery">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-star-fill"></i> {{ number_format(4.5 + (rand(0, 50) / 100), 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-bakery">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-bakery mb-0">Rs. {{ number_format($product->price, 2) }}</span>
                            @auth
                                <button class="btn btn-bakery btn-sm add-to-cart"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        data-image="{{ $product->image }}">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-bakery btn-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login to Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('menu') }}" class="btn btn-outline-bakery btn-lg">
                <i class="bi bi-journal-text me-2"></i>View Full Menu
            </a>
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-counter">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <span class="stat-number" data-target="15000">0</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <span class="stat-number" data-target="80">0</span>
                    <span class="stat-label">Pastry Varieties</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <span class="stat-number" data-target="15">0</span>
                    <span class="stat-label">Master Bakers</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <span class="stat-number" data-target="5">0</span>
                    <span class="stat-label">Years of Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=600&h=400&fit=crop"
                     alt="Bakery Interior"
                     class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-4">
                    <h2 class="display-5 fw-bold text-bakery mb-4">Our Story</h2>
                    <p class="lead mb-4">Sweet Delights Bakery began as a simple dream - to create a space where exceptional baking meets genuine community connection.</p>
                    <p class="mb-4">Founded in 2019 by baking enthusiasts Avindu and Mahesh, we've grown from a small neighborhood bakery to a beloved community gathering place. Our commitment to quality, freshness, and customer satisfaction drives everything we do.</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Fresh Daily</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Artisan Made</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Expert Crafted</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Community Driven</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('features') }}" class="btn btn-bakery">
                            <i class="bi bi-arrow-right me-2"></i>Learn More About Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-bakery mb-3">What Our Customers Say</h2>
                <p class="lead text-muted">Don't just take our word for it - hear from our amazing bakery community</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"The pastries here are absolutely divine! I've been coming to Sweet Delights for months now, and it's become my favorite spot. The croissants are the best in town!"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/niroda.jpg"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Nirodha Sampath</h6>
                                <small class="text-muted">Regular Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Amazing pastry quality and friendly service! I've tried bakeries all over the city, but nothing compares to the passion and dedication here."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/dinidu.png"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Dinidu Madusanka</h6>
                                <small class="text-muted">Pastry Enthusiast</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Perfect spot for meetings and catching up with friends. Great pastries, comfortable seating, and excellent atmosphere. What more could you ask for?"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/chanul.jpg"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Chanul Ranasinghe</h6>
                                <small class="text-muted">Business Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="py-5 bg-bakery text-white">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold mb-3">Special Offers</h2>
                <p class="lead">Don't miss out on these amazing deals and exclusive offers</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-bakery text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-percent fs-2"></i>
                        </div>
                        <h4 class="card-title">Happy Hour</h4>
                        <p class="card-text">Get 20% off all pastries from 2 PM to 5 PM, Monday through Friday.</p>
                        <span class="badge bg-bakery fs-6">2 PM - 5 PM</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-bakery text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-gift fs-2"></i>
                        </div>
                        <h4 class="card-title">Loyalty Program</h4>
                        <p class="card-text">Buy 10 pastries, get the 11th free! Sign up today and start earning points.</p>
                        <span class="badge bg-bakery fs-6">Free Registration</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-bakery text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-people fs-2"></i>
                        </div>
                        <h4 class="card-title">Group Discounts</h4>
                        <p class="card-text">Bring 4 or more friends and enjoy 15% off your entire order. Perfect for celebrations!</p>
                        <span class="badge bg-bakery fs-6">4+ People</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
@guest
<section class="py-5" style="background: var(--gradient-primary);">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-4">Join Our Bakery Community Today!</h2>
                <p class="lead mb-4">Create an account to unlock exclusive benefits, earn rewards, and get personalized recommendations from our expert bakers.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Sign Up Now
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Already a Member?
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

<!-- Newsletter Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3 class="mb-3">Stay Updated with Sweet Delights</h3>
                <p class="mb-0">Get the latest updates on new pastries, special offers, and exclusive events delivered straight to your inbox.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form class="row g-3">
                    <div class="col">
                        <input type="email" class="form-control form-control-lg" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-bakery btn-lg">
                            <i class="bi bi-send me-1"></i>Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .bg-bakery {
        background-color: var(--bakery-primary) !important;
    }

    .text-bakery {
        color: var(--bakery-primary) !important;
    }
</style>
@endpush

@push('scripts')
    <script>

        // Stats counter animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 20);
        }

        // Initialize counters when they come into view
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-target'));
                        animateCounter(counter, target);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            const statsSection = document.querySelector('.stats-counter');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const text = '"පාන් සුවඳට මිහිරි රසට ආස කරන ආත්ම එකතුවෙන නිවහන"';
                const element = document.getElementById('sinhalaTypewriter');
                const cursor = document.getElementById('cursor');
                let index = 0;

                function typeWriter() {
                    if (index < text.length) {
                        element.textContent += text.charAt(index);
                        index++;
                        setTimeout(typeWriter, 120);
                    } else {
                        setTimeout(() => {
                            cursor.style.opacity = '0';
                        }, 2000);
                    }
                }

                typeWriter();
            }, 1500);
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const text = '"A home where souls who love the smell of fresh bread and sweet delights gather"';
                const element = document.getElementById('englishTypewriter');
                const cursor = document.getElementById('cursor');
                let index = 0;

                function typeWriter() {
                    if (index < text.length) {
                        element.textContent += text.charAt(index);
                        index++;
                        setTimeout(typeWriter, 130);
                    } else {
                        setTimeout(() => {
                            cursor.style.opacity = '0';
                        }, 2000);
                    }
                }

                typeWriter();
            }, 1500);
        });

        // Notification system
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `custom-notification alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} alert-dismissible fade show`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;

            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Add to cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Cart functionality is now handled by cart.js
            console.log('Home page loaded, cart should be available');

            // Debug cart availability
            setTimeout(() => {
                if (window.cart) {
                    console.log('Cart is working properly');
                } else {
                    console.error('Cart not available on home page');
                }
            }, 1000);
        });

        // Quick Pay functionality
        window.quickPay = function(itemId, itemName, itemPrice, itemImage) {
            console.log('Quick pay initiated from home page');

            // Create single item order data
            const orderData = {
                items: [{
                    id: itemId,
                    name: itemName,
                    price: parseFloat(itemPrice),
                    quantity: 1,
                    image: itemImage
                }],
                customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
                customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
                customer_phone: '',
                order_type: 'dine_in',
                subtotal: parseFloat(itemPrice),
                tax: parseFloat(itemPrice) * 0.1,
                total: parseFloat(itemPrice) * 1.1,
                order_id: 'ORD' + Date.now()
            };

            // Store order data globally for payment modal
            window.currentOrderData = orderData;

            // Show payment modal
            if (typeof showPaymentModal === 'function') {
                showPaymentModal(orderData);
            } else {
                console.error('Payment modal not available');
                showNotification('Payment system not available', 'error');
            }
        };
    </script>

    @stack('scripts')
@endpush
@endsection