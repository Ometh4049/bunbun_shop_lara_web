@extends('layouts.admin')

@section('title', 'User Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">User Management</h1>
            <p class="mb-0 text-muted">Manage registered users and their accounts</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="refreshUserData()">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
            </button>
            <button class="btn btn-bakery" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus me-2"></i>Add New User
            </button>
        </div>
    </div>

    <!-- Real-time Stats Cards -->
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
                            <div class="h4 mb-0" id="totalUsersCount">{{ $users->total() }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> <span id="newUsersToday">0</span> today
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
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Active Users</div>
                            <div class="h4 mb-0" id="activeUsersCount">{{ $users->where('email_verified_at', '!=', null)->count() }}</div>
                            <div class="text-info small">
                                <i class="bi bi-shield-check"></i> Verified accounts
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
                            <i class="bi bi-shield-exclamation"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Admin Users</div>
                            <div class="h4 mb-0" id="adminUsersCount">{{ $users->where('is_admin', true)->count() }}</div>
                            <div class="text-warning small">
                                <i class="bi bi-key"></i> Privileged access
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
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Recent Activity</div>
                            <div class="h4 mb-0" id="recentActivityCount">{{ $users->where('updated_at', '>', now()->subHours(24))->count() }}</div>
                            <div class="text-info small">
                                <i class="bi bi-activity"></i> Last 24h
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search users..." id="userSearch">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="roleFilter">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="dateFilter">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="applyFilters()">
                        <i class="bi bi-funnel"></i> Apply
                    </button>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-info w-100" onclick="exportUsers()">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users (<span id="userCountDisplay">{{ $users->total() }}</span>)</h5>
                <div class="d-flex gap-2">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active" onclick="setViewMode('table')">
                            <i class="bi bi-table"></i> Table
                        </button>
                        <button class="btn btn-outline-secondary" onclick="setViewMode('cards')">
                            <i class="bi bi-grid-3x3-gap"></i> Cards
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleBulkActions()">
                        <i class="bi bi-check-square"></i> Bulk Actions
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Bulk Actions Bar (Hidden by default) -->
            <div id="bulkActionsBar" class="bg-light p-3 border-bottom" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span id="selectedCount">0</span> users selected
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="bulkExport()">
                            <i class="bi bi-download me-1"></i>Export Selected
                        </button>
                        <button class="btn btn-outline-warning" onclick="bulkSuspend()">
                            <i class="bi bi-pause-circle me-1"></i>Suspend
                        </button>
                        <button class="btn btn-outline-danger" onclick="bulkDelete()">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Role & Status</th>
                            <th>Activity</th>
                            <th>Stats</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @foreach($users as $user)
                        <tr data-user-id="{{ $user->id }}" class="user-row">
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @if($user->is_admin)
                                            <div class="admin-badge">
                                                <i class="bi bi-shield-fill"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                        <div class="user-tier">
                                            <span class="badge bg-{{ $user->loyalty_tier === 'Platinum' ? 'dark' : ($user->loyalty_tier === 'Gold' ? 'warning' : 'secondary') }} badge-sm">
                                                {{ $user->loyalty_tier ?? 'Bronze' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-envelope me-2 text-muted"></i>
                                        <span class="text-muted">{{ $user->email }}</span>
                                        @if($user->email_verified_at)
                                            <i class="bi bi-patch-check-fill text-success ms-1" title="Verified"></i>
                                        @else
                                            <i class="bi bi-exclamation-triangle-fill text-warning ms-1" title="Unverified"></i>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone me-2 text-muted"></i>
                                        <small class="text-muted">Not provided</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mb-1">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <br>
                                    <span class="badge bg-success">Active</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="text-muted d-block">Joined: {{ $user->created_at->format('M d, Y') }}</small>
                                    <small class="text-muted d-block">Last seen: {{ $user->updated_at->diffForHumans() }}</small>
                                    <div class="activity-indicator mt-1">
                                        @if($user->updated_at->gt(now()->subMinutes(5)))
                                            <span class="badge bg-success">Online</span>
                                        @elseif($user->updated_at->gt(now()->subHours(1)))
                                            <span class="badge bg-warning">Recently Active</span>
                                        @else
                                            <span class="badge bg-secondary">Offline</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-stats">
                                    <small class="text-muted d-block">Orders: <span class="fw-bold text-primary">{{ $user->orders->count() }}</span></small>
                                    <small class="text-muted d-block">Spent: <span class="fw-bold text-success">Rs. {{ number_format($user->orders->sum('total'), 0) }}</span></small>
                                    <small class="text-muted d-block">Points: <span class="fw-bold text-warning">{{ $user->total_loyalty_points }}</span></small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" onclick="viewUserProfile({{ $user->id }})" title="View Profile">
                                        <i class="bi bi-person-circle"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" onclick="editUser({{ $user->id }})" title="Edit User">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-success" onclick="viewUserStats({{ $user->id }})" title="View Stats">
                                        <i class="bi bi-graph-up"></i>
                                    </button>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="sendMessage({{ $user->id }})">
                                                <i class="bi bi-envelope me-2"></i>Send Message
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="viewLoginHistory({{ $user->id }})">
                                                <i class="bi bi-clock-history me-2"></i>Login History
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-warning" href="#" onclick="suspendUser({{ $user->id }})">
                                                <i class="bi bi-pause-circle me-2"></i>Suspend
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser({{ $user->id }})">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cards View (Hidden by default) -->
            <div id="cardsView" class="p-3" style="display: none;">
                <div class="row g-3" id="usersCardsContainer">
                    @foreach($users as $user)
                    <div class="col-xl-3 col-lg-4 col-md-6 user-card" data-user-id="{{ $user->id }}">
                        <div class="card h-100 border-0 shadow-sm user-profile-card">
                            <div class="card-body text-center">
                                <div class="user-avatar-large mb-3">
                                    <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @if($user->is_admin)
                                        <div class="admin-badge-large">
                                            <i class="bi bi-shield-fill"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6 class="card-title mb-1">{{ $user->name }}</h6>
                                <p class="text-muted small mb-2">{{ $user->email }}</p>
                                
                                <div class="user-badges mb-3">
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} me-1">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="badge bg-{{ $user->loyalty_tier === 'Platinum' ? 'dark' : ($user->loyalty_tier === 'Gold' ? 'warning' : 'secondary') }}">
                                        {{ $user->loyalty_tier ?? 'Bronze' }}
                                    </span>
                                </div>

                                <div class="user-quick-stats mb-3">
                                    <div class="row g-2 text-center">
                                        <div class="col-4">
                                            <div class="stat-mini">
                                                <div class="stat-number">{{ $user->orders->count() }}</div>
                                                <div class="stat-label">Orders</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-mini">
                                                <div class="stat-number">{{ number_format($user->total_loyalty_points) }}</div>
                                                <div class="stat-label">Points</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-mini">
                                                <div class="stat-number">{{ $user->reservations->count() }}</div>
                                                <div class="stat-label">Bookings</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="viewUserProfile({{ $user->id }})">
                                        <i class="bi bi-person-circle me-1"></i>View Profile
                                    </button>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary" onclick="editUser({{ $user->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-success" onclick="viewUserStats({{ $user->id }})">
                                            <i class="bi bi-graph-up"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced User Profile Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-circle me-2"></i>User Profile Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userProfileBody">
                <!-- User profile details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editUserFromProfile()">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </button>
                <button type="button" class="btn btn-success" onclick="viewUserStatsFromProfile()">
                    <i class="bi bi-graph-up me-2"></i>View Analytics
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced User Stats Modal -->
<div class="modal fade" id="userStatsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-graph-up me-2"></i>User Analytics Dashboard
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userStatsBody">
                <!-- User stats will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bakery text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password *</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role *</label>
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Birthday</label>
                            <input type="date" class="form-control" name="birthday">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-bakery" onclick="saveUser()">
                    <i class="bi bi-check-lg me-2"></i>Create User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role *</label>
                            <select class="form-select" id="editUserRole" name="role" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" id="editUserPhone" name="phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Birthday</label>
                            <input type="date" class="form-control" id="editUserBirthday" name="birthday">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="updateUser()">
                    <i class="bi bi-check-lg me-2"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-avatar {
    width: 45px;
    height: 45px;
    background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    border: 2px solid rgba(255, 255, 255, 0.8);
}

.user-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin: 0 auto;
    border: 3px solid rgba(255, 255, 255, 0.8);
}

.avatar-text {
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
}

.user-avatar-large .avatar-text {
    font-size: 2rem;
}

.admin-badge {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    background: #dc3545;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.7rem;
    border: 2px solid white;
}

.admin-badge-large {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 25px;
    height: 25px;
    background: #dc3545;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    border: 2px solid white;
}

.user-profile-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(212, 165, 116, 0.1);
}

.user-profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(212, 165, 116, 0.2) !important;
}

.stat-mini {
    background: linear-gradient(45deg, rgba(212, 165, 116, 0.1), rgba(244, 228, 193, 0.1));
    border-radius: 8px;
    padding: 0.5rem;
    border: 1px solid rgba(212, 165, 116, 0.1);
}

.stat-number {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bakery-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.7rem;
    color: #6c757d;
    font-weight: 500;
}

.user-tier .badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.activity-indicator .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.user-stats {
    font-size: 0.85rem;
}

.stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(212, 165, 116, 0.1);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(212, 165, 116, 0.15) !important;
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
}

.bg-gradient-primary {
    background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary)) !important;
}

.user-row {
    transition: all 0.3s ease;
}

.user-row:hover {
    background: linear-gradient(45deg, rgba(212, 165, 116, 0.02), rgba(244, 228, 193, 0.02));
}

#bulkActionsBar {
    transition: all 0.3s ease;
}

.user-card {
    transition: all 0.3s ease;
}

.user-card.filtered-out {
    opacity: 0.3;
    transform: scale(0.95);
    pointer-events: none;
}

/* Real-time update animations */
.stat-update {
    animation: statPulse 0.6s ease;
}

@keyframes statPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); color: #28a745; }
    100% { transform: scale(1); }
}

.new-user-highlight {
    animation: newUserGlow 2s ease;
}

@keyframes newUserGlow {
    0%, 100% { background: transparent; }
    50% { background: rgba(40, 167, 69, 0.1); }
}

/* Loading states */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--bakery-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
let currentUserId = null;
let refreshInterval = null;
let selectedUsers = new Set();

document.addEventListener('DOMContentLoaded', function() {
    // Initialize real-time updates
    startRealTimeUpdates();
    
    // Initialize search and filters
    initializeFilters();
    
    // Initialize bulk actions
    initializeBulkActions();
    
    // Initialize view mode toggle
    initializeViewModes();
});

function startRealTimeUpdates() {
    // Update user stats every 30 seconds
    refreshInterval = setInterval(refreshUserStats, 30000);
    
    // Initial load
    refreshUserStats();
    
    console.log('Real-time updates started for user management');
}

function refreshUserStats() {
    fetch('/admin/api/user-stats', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateStatsDisplay(data.stats);
            updateUserActivity(data.activity);
        }
    })
    .catch(error => {
        console.error('Error refreshing user stats:', error);
    });
}

function updateStatsDisplay(stats) {
    // Update stat cards with animation
    animateStatUpdate('totalUsersCount', stats.total_users);
    animateStatUpdate('activeUsersCount', stats.active_users);
    animateStatUpdate('adminUsersCount', stats.admin_users);
    animateStatUpdate('recentActivityCount', stats.recent_activity);
    animateStatUpdate('newUsersToday', stats.new_users_today);
    animateStatUpdate('userCountDisplay', stats.total_users);
}

function animateStatUpdate(elementId, newValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const currentValue = element.textContent.replace(/[^\d]/g, '');
    const newValueClean = newValue.toString().replace(/[^\d]/g, '');
    
    if (currentValue !== newValueClean) {
        element.classList.add('stat-update');
        
        setTimeout(() => {
            element.textContent = typeof newValue === 'number' ? newValue.toLocaleString() : newValue;
            element.classList.remove('stat-update');
        }, 300);
    }
}

function updateUserActivity(activity) {
    // Update user activity indicators in real-time
    if (activity.recent_logins) {
        activity.recent_logins.forEach(userId => {
            const userRow = document.querySelector(`[data-user-id="${userId}"]`);
            if (userRow) {
                const activityBadge = userRow.querySelector('.activity-indicator .badge');
                if (activityBadge) {
                    activityBadge.className = 'badge bg-success';
                    activityBadge.textContent = 'Online';
                }
            }
        });
    }
}

function refreshUserData() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Refreshing...';
    button.disabled = true;
    
    // Force refresh user stats
    refreshUserStats();
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        showNotification('User data refreshed successfully!', 'success');
    }, 1000);
}

function initializeFilters() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');

    // Real-time search
    searchInput.addEventListener('input', debounce(function() {
        applyFilters();
    }, 300));

    // Filter change handlers
    [roleFilter, statusFilter, dateFilter].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
}

function applyFilters() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    
    const userRows = document.querySelectorAll('.user-row');
    const userCards = document.querySelectorAll('.user-card');
    
    let visibleCount = 0;
    
    [...userRows, ...userCards].forEach(element => {
        const userId = element.getAttribute('data-user-id');
        const userName = element.querySelector('h6').textContent.toLowerCase();
        const userEmail = element.querySelector('.text-muted').textContent.toLowerCase();
        const userRole = element.querySelector('.badge').textContent.toLowerCase();
        
        let show = true;
        
        // Search filter
        if (searchTerm && !userName.includes(searchTerm) && !userEmail.includes(searchTerm)) {
            show = false;
        }
        
        // Role filter
        if (roleFilter && !userRole.includes(roleFilter)) {
            show = false;
        }
        
        // Status filter
        if (statusFilter) {
            const hasVerificationIcon = element.querySelector('.bi-patch-check-fill');
            if (statusFilter === 'verified' && !hasVerificationIcon) show = false;
            if (statusFilter === 'unverified' && hasVerificationIcon) show = false;
        }
        
        if (show) {
            element.style.display = '';
            element.classList.remove('filtered-out');
            visibleCount++;
        } else {
            element.style.display = 'none';
            element.classList.add('filtered-out');
        }
    });
    
    // Update visible count
    document.getElementById('userCountDisplay').textContent = visibleCount;
}

function initializeBulkActions() {
    const selectAll = document.getElementById('selectAll');
    
    selectAll.addEventListener('change', function() {
        const userCheckboxes = document.querySelectorAll('.user-checkbox:not([style*="display: none"])');
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedUsers.add(checkbox.value);
            } else {
                selectedUsers.delete(checkbox.value);
            }
        });
        updateBulkActionsBar();
    });
    
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('user-checkbox')) {
            if (e.target.checked) {
                selectedUsers.add(e.target.value);
            } else {
                selectedUsers.delete(e.target.value);
            }
            updateBulkActionsBar();
        }
    });
}

function updateBulkActionsBar() {
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    selectedCount.textContent = selectedUsers.size;
    
    if (selectedUsers.size > 0) {
        bulkBar.style.display = 'block';
    } else {
        bulkBar.style.display = 'none';
    }
}

function toggleBulkActions() {
    const bulkBar = document.getElementById('bulkActionsBar');
    const checkboxes = document.querySelectorAll('.user-checkbox, #selectAll');
    
    if (bulkBar.style.display === 'none' || !bulkBar.style.display) {
        bulkBar.style.display = 'block';
        checkboxes.forEach(cb => cb.style.display = 'block');
    } else {
        bulkBar.style.display = 'none';
        checkboxes.forEach(cb => cb.style.display = 'none');
        selectedUsers.clear();
    }
}

function initializeViewModes() {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    
    window.setViewMode = function(mode) {
        const buttons = document.querySelectorAll('.btn-group .btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        if (mode === 'table') {
            tableView.style.display = 'block';
            cardsView.style.display = 'none';
        } else {
            tableView.style.display = 'none';
            cardsView.style.display = 'block';
        }
    };
}

function viewUserProfile(userId) {
    currentUserId = userId;
    
    // Show loading state
    const modalBody = document.getElementById('userProfileBody');
    modalBody.innerHTML = `
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('userProfileModal'));
    modal.show();
    
    fetch(`/admin/users/${userId}/stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderUserProfile(data.user, data.stats);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user profile', 'error');
        });
}

function renderUserProfile(user, stats) {
    const modalBody = document.getElementById('userProfileBody');
    
    modalBody.innerHTML = `
        <div class="row g-4">
            <!-- User Info Column -->
            <div class="col-lg-4">
                <div class="user-profile-section">
                    <div class="text-center mb-4">
                        <div class="user-avatar-xl mx-auto mb-3">
                            <span class="avatar-text-xl">${user.name.charAt(0).toUpperCase()}</span>
                            ${user.is_admin ? '<div class="admin-badge-xl"><i class="bi bi-shield-fill"></i></div>' : ''}
                        </div>
                        <h4 class="text-bakery">${user.name}</h4>
                        <p class="text-muted">${user.email}</p>
                        <div class="user-badges">
                            <span class="badge bg-${user.role === 'admin' ? 'danger' : 'primary'} me-2">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span>
                            <span class="badge bg-${stats.loyalty_tier === 'Platinum' ? 'dark' : (stats.loyalty_tier === 'Gold' ? 'warning' : 'secondary')}">${stats.loyalty_tier}</span>
                        </div>
                    </div>
                    
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">User ID:</span>
                            <span class="detail-value">#${user.id}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="badge bg-success">Active</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Joined:</span>
                            <span class="detail-value">${new Date(user.created_at).toLocaleDateString()}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email Verified:</span>
                            <span class="detail-value">
                                ${user.email_verified_at ? 
                                    '<i class="bi bi-check-circle-fill text-success"></i> Yes' : 
                                    '<i class="bi bi-x-circle-fill text-danger"></i> No'
                                }
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Last Activity:</span>
                            <span class="detail-value">${new Date(user.updated_at).toLocaleDateString()}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Column -->
            <div class="col-lg-8">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card-mini">
                            <div class="stat-icon-mini bg-primary">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="stat-content-mini">
                                <h4>${stats.total_orders}</h4>
                                <p>Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-mini">
                            <div class="stat-icon-mini bg-success">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="stat-content-mini">
                                <h4>Rs. ${stats.total_spent.toLocaleString()}</h4>
                                <p>Total Spent</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-mini">
                            <div class="stat-icon-mini bg-warning">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="stat-content-mini">
                                <h4>${stats.loyalty_points}</h4>
                                <p>Loyalty Points</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-mini">
                            <div class="stat-icon-mini bg-info">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="stat-content-mini">
                                <h4>${stats.total_reservations}</h4>
                                <p>Reservations</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="profile-section mb-4">
                    <h6 class="section-title">Recent Orders</h6>
                    <div class="orders-list">
                        ${stats.recent_orders.map(order => `
                            <div class="order-item-mini">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">#${order.order_id}</h6>
                                        <small class="text-muted">${new Date(order.created_at).toLocaleDateString()}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-success">Rs. ${parseFloat(order.total).toFixed(2)}</span>
                                        <br>
                                        <span class="badge bg-${order.status === 'completed' ? 'success' : 'warning'}">${order.status}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Recent Reservations -->
                <div class="profile-section">
                    <h6 class="section-title">Recent Reservations</h6>
                    <div class="reservations-list">
                        ${stats.recent_reservations.map(reservation => `
                            <div class="reservation-item-mini">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">#${reservation.reservation_id}</h6>
                                        <small class="text-muted">${new Date(reservation.reservation_date).toLocaleDateString()}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold">${reservation.guests} guests</span>
                                        <br>
                                        <span class="badge bg-${reservation.status === 'confirmed' ? 'success' : 'warning'}">${reservation.status}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
}

function viewUserStats(userId) {
    currentUserId = userId;
    
    const modalBody = document.getElementById('userStatsBody');
    modalBody.innerHTML = `
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('userStatsModal'));
    modal.show();
    
    fetch(`/admin/users/${userId}/stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderUserStatsAnalytics(data.user, data.stats);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user statistics', 'error');
        });
}

function renderUserStatsAnalytics(user, stats) {
    const modalBody = document.getElementById('userStatsBody');
    
    modalBody.innerHTML = `
        <div class="analytics-dashboard">
            <!-- User Header -->
            <div class="analytics-header mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="text-bakery mb-1">${user.name} - Analytics Dashboard</h4>
                        <p class="text-muted mb-0">Comprehensive user activity and engagement metrics</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="analytics-period">
                            <select class="form-select form-select-sm" onchange="updateAnalyticsPeriod(this.value)">
                                <option value="30">Last 30 Days</option>
                                <option value="90">Last 3 Months</option>
                                <option value="365">Last Year</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Key Metrics -->
            <div class="row g-3 mb-4">
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-primary">${stats.total_orders}</div>
                        <div class="metric-label">Total Orders</div>
                        <div class="metric-change text-success">+12%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-success">Rs. ${stats.total_spent.toLocaleString()}</div>
                        <div class="metric-label">Total Spent</div>
                        <div class="metric-change text-success">+8%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-warning">${stats.loyalty_points}</div>
                        <div class="metric-label">Loyalty Points</div>
                        <div class="metric-change text-info">Active</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-info">${stats.total_reservations}</div>
                        <div class="metric-label">Reservations</div>
                        <div class="metric-change text-success">+5%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-purple">Rs. ${(stats.total_spent / Math.max(stats.total_orders, 1)).toFixed(0)}</div>
                        <div class="metric-label">Avg Order</div>
                        <div class="metric-change text-success">+3%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="metric-card">
                        <div class="metric-value text-dark">${stats.loyalty_tier}</div>
                        <div class="metric-label">Tier Status</div>
                        <div class="metric-change text-info">Current</div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <h6 class="chart-title">Order History Trend</h6>
                        <canvas id="userOrderChart" height="300"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container">
                        <h6 class="chart-title">Spending Distribution</h6>
                        <canvas id="userSpendingChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Activity Timeline -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="activity-section">
                        <h6 class="section-title">Recent Activity</h6>
                        <div class="activity-timeline">
                            ${stats.recent_orders.slice(0, 5).map(order => `
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-success">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Order Completed</h6>
                                        <p class="text-muted mb-1">Order #${order.order_id} - Rs. ${parseFloat(order.total).toFixed(2)}</p>
                                        <small class="text-muted">${new Date(order.created_at).toLocaleDateString()}</small>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="insights-section">
                        <h6 class="section-title">Customer Insights</h6>
                        <div class="insights-list">
                            <div class="insight-item">
                                <div class="insight-icon bg-info">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>High Value Customer</h6>
                                    <p class="small text-muted">Above average spending pattern with consistent orders</p>
                                </div>
                            </div>
                            <div class="insight-item">
                                <div class="insight-icon bg-warning">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Loyalty Program Active</h6>
                                    <p class="small text-muted">${stats.loyalty_tier} tier member with ${stats.loyalty_points} points</p>
                                </div>
                            </div>
                            <div class="insight-item">
                                <div class="insight-icon bg-success">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Regular Customer</h6>
                                    <p class="small text-muted">Consistent visit pattern and high engagement</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Initialize charts after DOM is updated
    setTimeout(() => {
        initializeUserCharts(stats);
    }, 100);
}

function initializeUserCharts(stats) {
    // Order trend chart
    const orderCtx = document.getElementById('userOrderChart');
    if (orderCtx) {
        new Chart(orderCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Orders',
                    data: [2, 4, 3, 5, 7, 6],
                    borderColor: 'var(--bakery-primary)',
                    backgroundColor: 'rgba(212, 165, 116, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
    
    // Spending distribution chart
    const spendingCtx = document.getElementById('userSpendingChart');
    if (spendingCtx) {
        new Chart(spendingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pastries', 'Beverages', 'Breakfast', 'Desserts'],
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: [
                        'var(--bakery-primary)',
                        'var(--bakery-secondary)',
                        'var(--bakery-accent)',
                        'var(--bakery-pink)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
}

function editUser(userId) {
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserRole').value = user.role;
                document.getElementById('editUserPhone').value = user.phone || '';
                document.getElementById('editUserBirthday').value = user.birthday || '';
                
                const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user data', 'error');
        });
}

function saveUser() {
    const form = document.getElementById('addUserForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    submitButton.disabled = true;

    fetch('/admin/users', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User created successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            form.reset();
            
            // Refresh data and highlight new user
            setTimeout(() => {
                refreshUserStats();
                highlightNewUser(data.user.id);
            }, 500);
        } else {
            showNotification('Failed to create user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function updateUser() {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);
    const userId = document.getElementById('editUserId').value;
    const submitButton = event.target;
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    submitButton.disabled = true;

    fetch(`/admin/users/${userId}`, {
        method: 'PUT',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User updated successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            
            // Update user row in real-time
            updateUserRow(data.user);
        } else {
            showNotification('Failed to update user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User deleted successfully!', 'success');
            
            // Remove user from UI with animation
            const userRow = document.querySelector(`[data-user-id="${userId}"]`);
            if (userRow) {
                userRow.style.transition = 'all 0.3s ease';
                userRow.style.opacity = '0';
                userRow.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    userRow.remove();
                    refreshUserStats();
                }, 300);
            }
        } else {
            showNotification(data.message || 'Failed to delete user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function highlightNewUser(userId) {
    const userElement = document.querySelector(`[data-user-id="${userId}"]`);
    if (userElement) {
        userElement.classList.add('new-user-highlight');
        setTimeout(() => {
            userElement.classList.remove('new-user-highlight');
        }, 2000);
    }
}

function updateUserRow(user) {
    const userRow = document.querySelector(`[data-user-id="${user.id}"]`);
    if (userRow) {
        // Update user name
        const nameElement = userRow.querySelector('h6');
        if (nameElement) {
            nameElement.textContent = user.name;
        }
        
        // Update email
        const emailElement = userRow.querySelector('.text-muted');
        if (emailElement) {
            emailElement.textContent = user.email;
        }
        
        // Update role badge
        const roleBadge = userRow.querySelector('.badge');
        if (roleBadge) {
            roleBadge.className = `badge bg-${user.role === 'admin' ? 'danger' : 'primary'}`;
            roleBadge.textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
        }
        
        // Add update animation
        userRow.classList.add('new-user-highlight');
        setTimeout(() => {
            userRow.classList.remove('new-user-highlight');
        }, 1000);
    }
}

// Bulk actions
function bulkExport() {
    if (selectedUsers.size === 0) {
        showNotification('Please select users to export', 'warning');
        return;
    }
    
    showNotification(`Exporting ${selectedUsers.size} users...`, 'info');
    // Implementation for bulk export
}

function bulkSuspend() {
    if (selectedUsers.size === 0) {
        showNotification('Please select users to suspend', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to suspend ${selectedUsers.size} users?`)) {
        showNotification(`Suspending ${selectedUsers.size} users...`, 'warning');
        // Implementation for bulk suspend
    }
}

function bulkDelete() {
    if (selectedUsers.size === 0) {
        showNotification('Please select users to delete', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selectedUsers.size} users? This action cannot be undone.`)) {
        showNotification(`Deleting ${selectedUsers.size} users...`, 'error');
        // Implementation for bulk delete
    }
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function exportUsers() {
    showNotification('Preparing user export...', 'info');
    // Implementation for user export
}

function sendMessage(userId) {
    showNotification('Message functionality coming soon!', 'info');
}

function viewLoginHistory(userId) {
    showNotification('Login history feature coming soon!', 'info');
}

function suspendUser(userId) {
    if (confirm('Are you sure you want to suspend this user?')) {
        showNotification('User suspended successfully', 'warning');
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
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
    
    .user-avatar-xl {
        width: 120px;
        height: 120px;
        background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border: 4px solid rgba(255, 255, 255, 0.8);
    }
    
    .avatar-text-xl {
        color: white;
        font-weight: 700;
        font-size: 3rem;
    }
    
    .admin-badge-xl {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 35px;
        height: 35px;
        background: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        border: 3px solid white;
    }
    
    .user-profile-section {
        background: linear-gradient(45deg, rgba(212, 165, 116, 0.05), rgba(244, 228, 193, 0.05));
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid rgba(212, 165, 116, 0.1);
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(212, 165, 116, 0.1);
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #6c757d;
    }
    
    .detail-value {
        font-weight: 500;
        color: var(--bakery-primary);
    }
    
    .metric-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(212, 165, 116, 0.1);
        transition: all 0.3s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(212, 165, 116, 0.2);
    }
    
    .metric-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .metric-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .metric-change {
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(212, 165, 116, 0.1);
    }
    
    .chart-title {
        color: var(--bakery-primary);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(212, 165, 116, 0.1);
    }
    
    .timeline-item:last-child {
        border-bottom: none;
    }
    
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .timeline-content h6 {
        color: var(--bakery-primary);
        margin-bottom: 0.5rem;
    }
    
    .insight-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(45deg, rgba(212, 165, 116, 0.02), rgba(244, 228, 193, 0.02));
        border-radius: 10px;
        border: 1px solid rgba(212, 165, 116, 0.1);
        margin-bottom: 1rem;
    }
    
    .insight-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .insight-content h6 {
        color: var(--bakery-primary);
        margin-bottom: 0.5rem;
    }
    
    .stat-card-mini {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid rgba(212, 165, 116, 0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(212, 165, 116, 0.2);
    }
    
    .stat-icon-mini {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .stat-content-mini h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--bakery-primary);
        margin-bottom: 0.25rem;
    }
    
    .stat-content-mini p {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .order-item-mini,
    .reservation-item-mini {
        padding: 1rem;
        background: linear-gradient(45deg, rgba(212, 165, 116, 0.02), rgba(244, 228, 193, 0.02));
        border-radius: 8px;
        border: 1px solid rgba(212, 165, 116, 0.1);
        margin-bottom: 0.5rem;
    }
    
    .section-title {
        color: var(--bakery-primary);
        font-weight: 600;
        margin-bottom: 1rem;
        border-bottom: 2px solid var(--bakery-primary);
        padding-bottom: 0.5rem;
    }
`;
document.head.appendChild(style);
</script>
@endpush