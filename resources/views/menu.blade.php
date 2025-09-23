@extends('layouts.master')

@section('title', 'Bakery Menu - Sweet Delights')
@section('description', 'Discover our artisanal bakery menu featuring fresh pastries, breads, cakes, and beverages crafted with love.')

@section('content')
<!-- Hero Section -->
<section class="hero-bakery menu-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Artisanal Bakery Menu</h1>
                <p class="lead text-white mb-4">Discover our handcrafted selection of fresh pastries, artisan breads, decadent cakes, and premium beverages. Each item is made with the finest ingredients and traditional techniques.</p>
                <div class="d-flex gap-3">
                    <a href="#menu-categories" class="btn btn-bakery btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Explore Menu
                    </a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Reserve Table
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image-container">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&h=700&fit=crop"
                         alt="Sweet Delights Pastries"
                         class="img-fluid rounded-3 shadow-lg floating">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Categories -->
<section id="menu-categories" class="py-5 section-white">
    <div class="container">
        <!-- Search Bar -->
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-6">
                <div class="search-container">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-bakery-brown"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="menuSearch" 
                               placeholder="Search our delicious pastries...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-10">
                <div class="category-filters d-flex flex-wrap justify-content-center gap-2">
                    <button class="category-filter-btn active" data-category="all">
                        <i class="bi bi-grid me-2"></i>All Items
                    </button>
                    <button class="category-filter-btn" data-category="fresh-bread">
                        <i class="bi bi-basket me-2"></i>Fresh Bread
                    </button>
                    <button class="category-filter-btn" data-category="pastries">
                        <i class="bi bi-cake2 me-2"></i>Pastries
                    </button>
                    <button class="category-filter-btn" data-category="cakes">
                        <i class="bi bi-cake me-2"></i>Cakes & Desserts
                    </button>
                    <button class="category-filter-btn" data-category="beverages">
                        <i class="bi bi-cup-hot me-2"></i>Beverages
                    </button>
                    <button class="category-filter-btn" data-category="breakfast">
                        <i class="bi bi-sunrise me-2"></i>Breakfast Items
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="menuLoading" class="text-center py-5">
            <div class="spinner-border text-bakery-brown" role="status">
                <span class="visually-hidden">Loading menu...</span>
            </div>
            <p class="mt-3 text-muted">Loading our delicious menu...</p>
        </div>

        <!-- Menu Items Grid -->
        <div class="row g-4" id="menuGrid" style="display: none;">
            <!-- Menu items will be loaded here dynamically -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="text-center py-5" style="display: none;">
            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">No items found</h4>
            <p class="text-muted">Try adjusting your search or category filter</p>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="py-5 section-beige">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-bakery-brown mb-3">Today's Special Offers</h2>
                <p class="lead text-muted">Don't miss these amazing deals at Sweet Delights</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                        <h4 class="card-title">Afternoon Treats</h4>
                        <p class="card-text">Get 20% off all pastries from 2 PM to 5 PM</p>
                        <div class="offer-time">
                            <span class="badge bg-bakery">2:00 PM - 5:00 PM</span>
                        </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-gift"></i>
                    </div>
                        <h4 class="card-title">Combo Deal</h4>
                        <p class="card-text">Any beverage + pastry for just Rs. 650 (Save Rs. 150)</p>
                        <div class="offer-time">
                            <span class="badge bg-success">All Day</span>
                        </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                        <h4 class="card-title">Loyalty Card</h4>
                        <p class="card-text">Buy 10 pastries, get the 11th absolutely free!</p>
                        <div class="offer-time">
                            <span class="badge bg-info">Sign Up Today</span>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .search-container {
        position: relative;
    }

    .search-container .input-group-text {
        border-radius: 15px 0 0 15px;
        border: 2px solid var(--bakery-beige);
        border-right: none;
    }

    .search-container .form-control {
        border-radius: 0 15px 15px 0;
        border: 2px solid var(--bakery-beige);
        border-left: none;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
    }

    .search-container .form-control:focus {
        border-color: var(--bakery-terracotta);
        box-shadow: 0 0 0 0.2rem rgba(216, 138, 106, 0.25);
        border-left: none;
    }

    .search-container .input-group-text:has(+ .form-control:focus) {
        border-color: var(--bakery-terracotta);
    }

    .menu-hero {
        background: linear-gradient(135deg,
                    rgba(212, 165, 116, 0.9),
                    rgba(244, 228, 193, 0.8)),
                    url('https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .menu-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .menu-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .hero-image-container {
        position: relative;
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .category-filters .btn {
        margin: 0.25rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .category-filters .btn:not(.active):hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 165, 116, 0.25);
    }

    .product-card {
        border: none;
        border-radius: 25px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        background: white;
        height: 100%;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 50px rgba(212, 165, 116, 0.2);
    }

    .product-image {
        height: 280px;
        object-fit: cover;
        width: 100%;
        transition: all 0.4s ease;
        border-radius: 25px 25px 0 0;
    }

    .product-card:hover .product-image {
        transform: scale(1.08);
    }

    .product-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        height: calc(100% - 280px);
    }

    .product-category {
        display: inline-block;
        background: var(--bakery-pink);
        color: var(--bakery-brown);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-title {
        font-family: var(--font-heading);
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--bakery-brown);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .product-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }

    .product-price {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--bakery-terracotta);
        margin-bottom: 1.5rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        right: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 2;
    }

    .product-rating {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: var(--bakery-brown);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .product-special {
        background: linear-gradient(45deg, var(--bakery-terracotta), var(--bakery-pink));
        color: white;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .product-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .product-actions .btn {
        flex: 1;
        border-radius: 15px;
        font-weight: 600;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .product-actions .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.6s;
    }

    .product-actions .btn:hover::before {
        left: 100%;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(212, 165, 116, 0.1);
    }

    .prep-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .calories-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .add-to-cart {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .add-to-cart::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s;
    }

    .add-to-cart:hover::before {
        left: 100%;
    }

    .add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 165, 116, 0.4);
    }

    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 15px;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .menu-item {
        transition: all 0.3s ease;
    }

    .menu-item.hidden {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        color: #666;
    }

    /* Enhanced responsive design */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }
    }

    @media (max-width: 1199px) {
        .product-content {
            padding: 1.5rem;
        }
        
        .product-image {
            height: 250px;
        }
    }

    @media (max-width: 991px) {
        .product-image {
            height: 220px;
        }
        
        .product-content {
            padding: 1.25rem;
        }
        
        .product-title {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 767px) {
        .menu-hero {
            min-height: 70vh;
        }
        
        .display-3 {
            font-size: 2.2rem;
        }
        
        .category-filters {
            flex-direction: column;
            align-items: center;
        }
        
        .category-filter-btn {
            width: 100%;
            max-width: 280px;
            margin: 0.25rem 0;
        }
        
        .product-actions {
            flex-direction: column;
        }
        
        .product-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 575px) {
        .product-content {
            padding: 1rem;
        }
        
        .product-image {
            height: 200px;
        }
        
        .search-container .input-group {
            margin: 0 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
let allMenuItems = [];
let filteredItems = [];
let currentCategory = 'all';

document.addEventListener('DOMContentLoaded', function() {
    loadMenuItems();
    initializeFilters();
    initializeSearch();
});

async function loadMenuItems() {
    try {
        const response = await fetch('/api/menu');
        const data = await response.json();
        
        if (data.success) {
            allMenuItems = data.menu_items;
            filteredItems = [...allMenuItems];
            renderMenuItems();
            hideLoading();
        } else {
            throw new Error('Failed to load menu items');
        }
    } catch (error) {
        console.error('Error loading menu:', error);
        showError();
    }
}

function hideLoading() {
    document.getElementById('menuLoading').style.display = 'none';
    document.getElementById('menuGrid').style.display = 'block';
}

function showError() {
    document.getElementById('menuLoading').innerHTML = `
        <div class="text-center py-5">
            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Failed to load menu</h4>
            <p class="text-muted">Please refresh the page to try again</p>
            <button class="btn btn-bakery" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh Page
            </button>
        </div>
    `;
}

function renderMenuItems() {
    const menuGrid = document.getElementById('menuGrid');
    const emptyState = document.getElementById('emptyState');
    
    if (filteredItems.length === 0) {
        menuGrid.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }
    
    menuGrid.style.display = 'block';
    emptyState.style.display = 'none';
    
    menuGrid.innerHTML = filteredItems.map((item, index) => {
        const categoryMap = {
            'Fresh Bread': 'fresh-bread',
            'Pastries': 'pastries', 
            'Cakes & Desserts': 'cakes',
            'Beverages': 'beverages',
            'Breakfast Items': 'breakfast'
        };
        
        const categoryClass = categoryMap[item.category] || 'other';
        const rating = (4.5 + (Math.random() * 0.5)).toFixed(1);
        const isPopular = index < 3;
        const isNew = index < 2;
        
        return `
            <div class="col-lg-4 col-md-6 col-12 menu-item" data-category="${categoryClass}" data-aos="fade-up" data-aos-delay="${(index % 3 + 1) * 100}">
                <div class="product-card">
                    <div class="position-relative overflow-hidden">
                        <img src="${item.image}" class="product-image" alt="${item.name}" loading="lazy">
                        <div class="product-badges">
                            <div class="product-rating">
                                <i class="bi bi-star-fill text-warning me-1"></i>${rating}
                            </div>
                            ${isPopular ? '<div class="product-special">Popular</div>' : ''}
                            ${isNew ? '<div class="product-special">New</div>' : ''}
                        </div>
                    </div>
                    <div class="product-content">
                        <div class="product-category">${item.category}</div>
                        <h5 class="product-title">${item.name}</h5>
                        <p class="product-description">${item.description}</p>
                        <div class="product-price">Rs. ${parseFloat(item.price).toFixed(2)}</div>
                        <div class="product-actions">
                            ${getAuthButtons(item)}
                        </div>
                        <div class="product-meta">
                            <div class="prep-time">
                                <i class="bi bi-clock"></i>
                                <span>${item.preparation_time || 'Ready soon'}</span>
                            </div>
                            ${item.calories ? `
                                <div class="calories-info">
                                    <i class="bi bi-speedometer"></i>
                                    <span>${item.calories} cal</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    // Re-initialize AOS for new elements
    AOS.refresh();
}

function getAuthButtons(item) {
    const isAuthenticated = document.querySelector('meta[name="user-name"]');
    
    if (isAuthenticated) {
        return `
            <button class="btn btn-bakery add-to-cart"
                    data-id="${item.id}"
                    data-name="${item.name}"
                    data-price="${item.price}"
                    data-image="${item.image}">
                <i class="bi bi-cart-plus me-2"></i>Add to Cart
            </button>
            <button class="btn btn-outline-bakery"
                    onclick="quickPay(${item.id}, '${item.name}', ${item.price}, '${item.image}')">
                <i class="bi bi-lightning me-2"></i>Quick Order
            </button>
        `;
    } else {
        return `
            <a href="/login" class="btn btn-bakery">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login to Order
            </a>
            <a href="/register" class="btn btn-outline-bakery">
                <i class="bi bi-person-plus me-2"></i>Sign Up
            </a>
        `;
    }
}

function initializeFilters() {
    const filterButtons = document.querySelectorAll('.category-filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            currentCategory = category;
            applyFilters();
        });
    });
}

function initializeSearch() {
    const searchInput = document.getElementById('menuSearch');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 300);
    });
}

function applyFilters() {
    const searchTerm = document.getElementById('menuSearch').value.toLowerCase();
    
    filteredItems = allMenuItems.filter(item => {
        const categoryMap = {
            'Fresh Bread': 'fresh-bread',
            'Pastries': 'pastries',
            'Cakes & Desserts': 'cakes', 
            'Beverages': 'beverages',
            'Breakfast Items': 'breakfast'
        };
        
        const itemCategory = categoryMap[item.category] || 'other';
        const matchesCategory = currentCategory === 'all' || itemCategory === currentCategory;
        
        const matchesSearch = !searchTerm || 
            item.name.toLowerCase().includes(searchTerm) ||
            item.description.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm);
            
        return matchesCategory && matchesSearch;
    });
    
    renderMenuItems();
}

// Quick Pay functionality
function quickPay(itemId, itemName, itemPrice, itemImage) {
    console.log('Quick pay initiated for:', itemName);
    }

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

    window.currentOrderData = orderData;

    if (typeof showPaymentModal === 'function') {
        showPaymentModal(orderData);
    } else {
        console.error('Payment modal not available');
        showNotification('Payment system not available', 'error');
    }
}

// Enhanced notification function
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
        }
    }

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
</script>
@endpush
@endsection


        .menu-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .category-filters {
            flex-direction: column;
        }

        .category-filters .btn {
            width: 100%;
            margin: 0.25rem 0;
        }
    }

    /* Ensure equal height cards in each row */
    .menu-item .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .menu-item .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .menu-item .card-text {
        flex: 1;
    }
</style>
@endpush

@push('scripts')
<script>
// Menu Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const menuItems = document.querySelectorAll('.menu-item');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        menuItems.forEach(item => {
            const title = item.querySelector('.menu-item-title').textContent.toLowerCase();
            const description = item.querySelector('.menu-item-description').textContent.toLowerCase();
            const category = item.querySelector('.menu-item-category').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
                item.style.display = 'block';
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
                setTimeout(() => {
                    if (item.classList.contains('hidden')) {
                        item.style.display = 'none';
                    }
                }, 300);
            }
        });
    });
    
    // Category Filter Functionality
    const filterButtons = document.querySelectorAll('.category-filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Filter items
            menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                
                if (category === 'all' || itemCategory === category) {
                    item.style.display = 'block';
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });
        });
    });
});

// Quick Pay functionality
function quickPay(itemId, itemName, itemPrice, itemImage) {
    console.log('Quick pay initiated for:', itemName);

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

    console.log('Quick pay order data prepared:', orderData);

    // Show payment modal
    if (typeof showPaymentModal === 'function') {
        showPaymentModal(orderData);
    } else {
        console.error('Payment modal not available');
        showNotification('Payment system not available', 'error');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize menu functionality
    initializeMenuFilters();
    initializeMenuSearch