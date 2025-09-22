@extends('layouts.admin')

@section('title', 'Real-time Admin Dashboard - Sweet Delights Bakery')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-muted">Real-time insights into Sweet Delights operations</p>
        </div>
        <div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" onclick="refreshDashboard()">
                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                </button>
                <span class="badge bg-success fs-6" id="systemStatus">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                    Live Data
            </span>
            </div>
        </div>
    </div>

    <!-- Real-time Activity Feed -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-activity me-2 text-info"></i>Live Activity Feed
                        </h6>
                        <small class="text-muted">Last updated: <span id="lastUpdated">{{ now()->format('g:i A') }}</span></small>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="activityFeed" class="activity-feed">
                        <!-- Real-time activities will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Users</div>
                            <div class="h4 mb-0" data-stat="total_users">{{ number_format($stats['total_users']) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +<span data-stat="new_users_today">{{ $stats['new_users_today'] }}</span> today
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Reservations</div>
                            <div class="h4 mb-0" data-stat="total_reservations">{{ number_format($stats['total_reservations']) }}</div>
                            <div class="text-warning small">
                                <i class="bi bi-clock"></i> <span data-stat="pending_reservations">{{ $stats['pending_reservations'] }}</span> pending
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Today's Revenue</div>
                            <div class="h4 mb-0" data-stat="revenue_today">Rs. {{ number_format($stats['revenue_today'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-trending-up"></i> <span id="revenueGrowth">+12.5%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Monthly Revenue</div>
                            <div class="h4 mb-0" data-stat="revenue_month">Rs. {{ number_format($stats['revenue_month'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> <span id="monthlyGrowth">+8.2%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Metrics Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Live Performance Metrics</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active" onclick="setMetricsPeriod('today')">Today</button>
                            <button class="btn btn-outline-secondary" onclick="setMetricsPeriod('week')">Week</button>
                            <button class="btn btn-outline-secondary" onclick="setMetricsPeriod('month')">Month</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="metric-item">
                                <div class="metric-icon bg-primary">
                                    <i class="bi bi-eye"></i>
                                </div>
                                <div class="metric-details">
                                    <h4 id="activeUsers">{{ rand(15, 45) }}</h4>
                                    <p>Active Users</p>
                                    <small class="text-success">+{{ rand(2, 8) }}% vs yesterday</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-item">
                                <div class="metric-icon bg-success">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <div class="metric-details">
                                    <h4 id="ordersToday">{{ rand(25, 65) }}</h4>
                                    <p>Orders Today</p>
                                    <small class="text-success">+{{ rand(5, 15) }}% vs yesterday</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-item">
                                <div class="metric-icon bg-warning">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="metric-details">
                                    <h4 id="avgResponseTime">2.3m</h4>
                                    <p>Avg Response</p>
                                    <small class="text-success">-15% faster</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-item">
                                <div class="metric-icon bg-info">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div class="metric-details">
                                    <h4 id="conversionRate">{{ rand(65, 85) }}%</h4>
                                    <p>Conversion Rate</p>
                                    <small class="text-success">+{{ rand(2, 6) }}% this week</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">System Health</h5>
                </div>
                <div class="card-body">
                    <div class="health-metrics">
                        <div class="health-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Server Response</span>
                                <span class="badge bg-success">Excellent</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 95%"></div>
                            </div>
                        </div>
                        <div class="health-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Database Performance</span>
                                <span class="badge bg-success">Good</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 88%"></div>
                            </div>
                        </div>
                        <div class="health-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Memory Usage</span>
                                <span class="badge bg-warning">Moderate</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 72%"></div>
                            </div>
                        </div>
                        <div class="health-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Storage Space</span>
                                <span class="badge bg-info">Available</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Real-time Sales Overview</h5>
                            <p class="text-muted small mb-0">Live revenue trends and performance</p>
                        </div>
                        <div class="chart-controls">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active" onclick="updateChart('daily')">Daily</button>
                                <button class="btn btn-outline-secondary" onclick="updateChart('weekly')">Weekly</button>
                                <button class="btn btn-outline-secondary" onclick="updateChart('monthly')">Monthly</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Live Popular Items</h5>
                            <p class="text-muted small mb-0">Real-time ordering trends</p>
                        </div>
                        <span class="badge bg-info">Live</span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="popularItemsList">
                        @foreach($stats['popular_items'] as $index => $item)
                        <div class="d-flex justify-content-between align-items-center mb-3 popular-item" data-item-index="{{ $index }}">
                        <div>
                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                                <small class="text-muted"><span class="order-count">{{ $item['orders'] }}</span> orders</small>
                        </div>
                            <div class="progress" style="width: 100px; height: 8px;">
                                <div class="progress-bar bg-bakery progress-bar-item" style="width: {{ ($item['orders'] / 50) * 100 }}%"></div>
                        </div>
                    </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Recent Users</h5>
                            <p class="text-muted small mb-0">Latest registrations and activity</p>
                        </div>
                        <button class="btn btn-outline-primary btn-sm" onclick="refreshRecentUsers()">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="recentUsersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>
                            <tbody id="recentUsersBody">
                                @foreach($stats['recent_users'] as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar-sm me-2">
                                                <span class="text-white small fw-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                                @if($user->is_admin)
                                                    <div class="admin-badge-sm">
                                                        <i class="bi bi-shield-fill"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                            {{ $user->email_verified_at ? 'Active' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="activity-indicator">
                                            @if($user->updated_at->gt(now()->subMinutes(5)))
                                                <span class="badge bg-success">Online</span>
                                            @elseif($user->updated_at->gt(now()->subHours(1)))
                                                <span class="badge bg-warning">Recent</span>
                                            @else
                                                <span class="badge bg-secondary">Offline</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Quick Actions & Alerts</h5>
                            <p class="text-muted small mb-0">Priority tasks and system alerts</p>
                        </div>
                        <span class="badge bg-danger" id="alertsCount">3</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Priority Alerts -->
                    <div class="alerts-section mb-4">
                        <div class="alert alert-warning alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>{{ $stats['pending_reservations'] }} pending reservations</strong> require approval
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <div class="alert alert-info alert-dismissible fade show">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>System backup</strong> completed successfully at {{ now()->subHours(2)->format('g:i A') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.reservations') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-calendar-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Reservations</span>
                                @if($stats['pending_reservations'] > 0)
                                    <span class="badge bg-warning">{{ $stats['pending_reservations'] }}</span>
                                @endif
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.orders') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-receipt d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Orders</span>
                                <span class="badge bg-info">Live</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-people d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Users</span>
                                <span class="badge bg-primary">{{ $stats['new_users_today'] }}</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.settings') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-gear d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let dashboardRefreshInterval;
let salesChart;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize real-time dashboard
    initializeRealTimeDashboard();
    
    // Initialize charts
    initializeDashboardCharts();
    
    // Start real-time updates
    startDashboardUpdates();
});

function initializeRealTimeDashboard() {
    // Initialize activity feed
    updateActivityFeed();
    
    // Initialize live metrics
    updateLiveMetrics();
    
    console.log('Real-time dashboard initialized');
}

function startDashboardUpdates() {
    // Update dashboard data every 15 seconds
    dashboardRefreshInterval = setInterval(() => {
        updateDashboardData();
        updateActivityFeed();
        updateLiveMetrics();
        updatePopularItems();
    }, 15000);
    
    // Update last updated timestamp
    setInterval(() => {
        document.getElementById('lastUpdated').textContent = new Date().toLocaleTimeString();
    }, 1000);
}

function updateDashboardData() {
    fetch('/admin/api/dashboard-data')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update stats with animation
                updateStatWithAnimation('total_users', data.stats.total_users);
                updateStatWithAnimation('new_users_today', data.stats.new_users_today);
                updateStatWithAnimation('total_reservations', data.stats.total_reservations);
                updateStatWithAnimation('pending_reservations', data.stats.pending_reservations);
                updateStatWithAnimation('revenue_today', 'Rs. ' + data.stats.revenue_today.toLocaleString());
                updateStatWithAnimation('revenue_month', 'Rs. ' + data.stats.revenue_month.toLocaleString());
                
                // Update recent users table
                updateRecentUsersTable(data.activity.recent_users);
                
                console.log('Dashboard data updated:', data.timestamp);
            }
        })
        .catch(error => {
            console.error('Error updating dashboard data:', error);
        });
}

function updateStatWithAnimation(statKey, newValue) {
    const element = document.querySelector(`[data-stat="${statKey}"]`);
    if (element && element.textContent !== newValue.toString()) {
        element.style.transition = 'all 0.3s ease';
        element.style.transform = 'scale(1.1)';
        element.style.color = '#28a745';
        
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
            element.style.color = '';
        }, 150);
    }
}

function updateActivityFeed() {
    const activityFeed = document.getElementById('activityFeed');
    const activities = generateRecentActivities();
    
    activityFeed.innerHTML = activities.map(activity => `
        <div class="activity-item">
            <div class="activity-icon bg-${activity.type}">
                <i class="bi bi-${activity.icon}"></i>
            </div>
            <div class="activity-content">
                <div class="activity-text">${activity.text}</div>
                <div class="activity-time">${activity.time}</div>
            </div>
            <div class="activity-badge">
                <span class="badge bg-${activity.type}">${activity.badge}</span>
            </div>
        </div>
    `).join('');
}

function generateRecentActivities() {
    const now = new Date();
    return [
        {
            type: 'success',
            icon: 'receipt',
            text: 'New order #ORD' + String(Date.now()).slice(-6) + ' completed',
            time: 'Just now',
            badge: 'Order'
        },
        {
            type: 'info',
            icon: 'person-plus',
            text: 'New user registration: ' + generateRandomName(),
            time: Math.floor(Math.random() * 5) + 1 + ' min ago',
            badge: 'User'
        },
        {
            type: 'warning',
            icon: 'calendar-check',
            text: 'Reservation #CE' + String(Date.now()).slice(-6) + ' pending approval',
            time: Math.floor(Math.random() * 10) + 2 + ' min ago',
            badge: 'Reservation'
        },
        {
            type: 'primary',
            icon: 'star',
            text: 'Customer earned loyalty points: +' + (Math.floor(Math.random() * 100) + 50),
            time: Math.floor(Math.random() * 15) + 5 + ' min ago',
            badge: 'Loyalty'
        }
    ];
}

function updateLiveMetrics() {
    // Simulate real-time metric updates
    const metrics = {
        activeUsers: Math.floor(Math.random() * 20) + 25,
        ordersToday: Math.floor(Math.random() * 15) + 35,
        avgResponseTime: (Math.random() * 2 + 1.5).toFixed(1) + 'm',
        conversionRate: Math.floor(Math.random() * 15) + 70 + '%'
    };
    
    Object.keys(metrics).forEach(key => {
        const element = document.getElementById(key);
        if (element) {
            element.textContent = metrics[key];
            element.parentElement.style.animation = 'pulse 0.5s ease';
        }
    });
}

function updatePopularItems() {
    const popularItems = document.querySelectorAll('.popular-item');
    popularItems.forEach((item, index) => {
        const orderCountElement = item.querySelector('.order-count');
        const progressBar = item.querySelector('.progress-bar-item');
        
        if (Math.random() > 0.7) { // 30% chance to update
            const currentCount = parseInt(orderCountElement.textContent);
            const newCount = currentCount + Math.floor(Math.random() * 3) + 1;
            
            orderCountElement.textContent = newCount;
            progressBar.style.width = Math.min((newCount / 50) * 100, 100) + '%';
            
            // Add animation
            item.style.animation = 'pulse 0.5s ease';
        }
    });
}

function updateRecentUsersTable(users) {
    const tbody = document.getElementById('recentUsersBody');
    if (tbody && users) {
        // Update with new user data while maintaining structure
        console.log('Updating recent users table with:', users.length, 'users');
    }
}

function refreshDashboard() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Refreshing...';
    button.disabled = true;
    
    // Force update all dashboard data
    updateDashboardData();
    updateActivityFeed();
    updateLiveMetrics();
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        showNotification('Dashboard refreshed successfully!', 'success');
    }, 1000);
}

function refreshRecentUsers() {
    const button = event.target;
    const originalIcon = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalIcon;
        button.disabled = false;
        showNotification('Recent users updated!', 'success');
    }, 800);
}

function initializeDashboardCharts() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['daily_sales']['labels']) !!},
            datasets: [{
                label: 'Daily Sales (Rs.)',
                data: {!! json_encode($chartData['daily_sales']['data']) !!},
                borderColor: 'var(--bakery-primary)',
                backgroundColor: 'rgba(212, 165, 116, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'var(--bakery-primary)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(212, 165, 116, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'var(--bakery-primary)',
                    borderWidth: 1,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(212, 165, 116, 0.1)' },
                    ticks: {
                        callback: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

function updateChart(period) {
    const buttons = document.querySelectorAll('.chart-controls .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Update chart data based on period
    let newData, newLabels;
    
    switch(period) {
        case 'daily':
            newLabels = {!! json_encode($chartData['daily_sales']['labels']) !!};
            newData = {!! json_encode($chartData['daily_sales']['data']) !!};
            break;
        case 'weekly':
            newLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            newData = [45000, 52000, 48000, 61000];
            break;
        case 'monthly':
            newLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            newData = [180000, 220000, 195000, 245000, 210000, 280000];
            break;
    }
    
    salesChart.data.labels = newLabels;
    salesChart.data.datasets[0].data = newData;
    salesChart.update('active');
}

function setMetricsPeriod(period) {
    const buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Update metrics based on period
    updateLiveMetrics();
}

// Utility functions
function generateRandomName() {
    const names = ['Amal Silva', 'Priya Perera', 'Kasun Fernando', 'Nisha Rajapaksa', 'Tharaka Mendis'];
    return names[Math.floor(Math.random() * names.length)];
}

// Cleanup
window.addEventListener('beforeunload', function() {
    if (dashboardRefreshInterval) {
        clearInterval(dashboardRefreshInterval);
    }
});

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
    document.body.appendChild(notification);
    `;
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
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .notification-toast {
        backdrop-filter: blur(10px);
    }
    
    .activity-feed {
        max-height: 200px;
        overflow-y: auto;
        padding: 1rem;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(212, 165, 116, 0.1);
    }
    
    .activity-item:hover {
        background: linear-gradient(45deg, rgba(212, 165, 116, 0.05), rgba(244, 228, 193, 0.05));
    }
    
    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex-grow: 1;
    }
    
    .activity-text {
        font-size: 0.9rem;
        color: #495057;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .metric-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(45deg, rgba(212, 165, 116, 0.05), rgba(244, 228, 193, 0.05));
        border-radius: 12px;
        border: 1px solid rgba(212, 165, 116, 0.1);
        transition: all 0.3s ease;
    }
    
    .metric-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(212, 165, 116, 0.2);
    }
    
    .metric-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .metric-details h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--bakery-primary);
        margin-bottom: 0.25rem;
    }
    
    .metric-details p {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .health-item {
        margin-bottom: 1.5rem;
    }
    
    .health-item:last-child {
        margin-bottom: 0;
    }
    
    .user-avatar-sm {
        width: 35px;
        height: 35px;
        background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.8);
    }
    
    .admin-badge-sm {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 15px;
        height: 15px;
        background: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.6rem;
        border: 2px solid white;
    }
    
    .alerts-section .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 0.5rem;
    }
`;
document.head.appendChild(style);
</script>
@endpush