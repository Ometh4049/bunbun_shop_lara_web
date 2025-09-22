@extends('layouts.admin')

@section('title', 'Users Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-people me-3 text-bakery"></i>
                    Users Management
                </h1>
                <p class="lead text-muted mb-0">Manage customer accounts and user permissions</p>
            </div>
            <div>
                <button class="btn btn-bakery" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- User Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="totalUsersCount">{{ $users->total() }}</h3>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="activeUsersCount">{{ $users->where('email_verified_at', '!=', null)->count() }}</h3>
                    <p class="text-muted mb-0">Verified Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-shield"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="adminUsersCount">{{ $users->where('is_admin', true)->count() }}</h3>
                    <p class="text-muted mb-0">Admin Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="newUsersCount">{{ $users->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                    <p class="text-muted mb-0">New This Week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search users..." id="userSearch">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="roleFilter">
                        <option value="">All Roles</option>
                        <option value="customer">Customers</option>
                        <option value="admin">Administrators</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-bakery w-100" onclick="exportUsers()">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">All Users</h5>
                <div class="d-flex gap-2">
                    <span class="badge bg-info">{{ $users->total() }} Total</span>
                    <button class="btn btn-outline-bakery btn-sm" onclick="refreshUsers()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Last Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr data-user-id="{{ $user->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <span class="avatar-text">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        @if($user->is_admin)
                                            <div class="admin-badge">
                                                <i class="bi bi-shield-fill"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <i class="bi bi-patch-check-fill text-success ms-1" title="Verified"></i>
                                @else
                                    <i class="bi bi-exclamation-triangle-fill text-warning ms-1" title="Unverified"></i>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->is_admin ? 'danger' : 'primary' }}">
                                    {{ $user->is_admin ? 'Administrator' : 'Customer' }}
                                </span>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <span>{{ $user->created_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="activity-status">
                                    @if($user->updated_at->gt(now()->subMinutes(5)))
                                        <span class="badge bg-success">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                            Online
                                        </span>
                                    @elseif($user->updated_at->gt(now()->subHours(1)))
                                        <span class="badge bg-warning">Recent</span>
                                    @else
                                        <span class="badge bg-secondary">Offline</span>
                                    @endif
                                </div>
                                <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" onclick="viewUser({{ $user->id }})" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-bakery" onclick="editUser({{ $user->id }})" title="Edit User">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if($user->id !== Auth::id())
                                        <button class="btn btn-outline-danger" onclick="deleteUser({{ $user->id }})" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <div class="row g-4">
                        <!-- Personal Information -->
                        <div class="col-12">
                            <h6 class="text-bakery mb-3 fw-bold">
                                <i class="bi bi-person-circle me-2"></i>Personal Information
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person me-2"></i>Full Name *
                            </label>
                            <input type="text" class="form-control form-control-lg" name="name" required placeholder="Enter full name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2"></i>Email Address *
                            </label>
                            <input type="email" class="form-control form-control-lg" name="email" required placeholder="Enter email address">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-telephone me-2"></i>Phone Number
                            </label>
                            <input type="tel" class="form-control form-control-lg" name="phone" placeholder="+94 XX XXX XXXX">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-heart me-2"></i>Birthday
                            </label>
                            <input type="date" class="form-control form-control-lg" name="birthday">
                        </div>

                        <!-- Account Settings -->
                        <div class="col-12 mt-4">
                            <h6 class="text-bakery mb-3 fw-bold">
                                <i class="bi bi-gear me-2"></i>Account Settings
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-shield me-2"></i>Role *
                            </label>
                            <select class="form-select form-select-lg" name="role" required>
                                <option value="">Select Role</option>
                                <option value="customer">Customer</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-key me-2"></i>Password *
                            </label>
                            <input type="password" class="form-control form-control-lg" name="password" required placeholder="Enter password">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-key-fill me-2"></i>Confirm Password *
                            </label>
                            <input type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Confirm password">
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
                    <input type="hidden" id="editUserId">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person me-2"></i>Full Name *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editUserName" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2"></i>Email Address *
                            </label>
                            <input type="email" class="form-control form-control-lg" id="editUserEmail" name="email" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-telephone me-2"></i>Phone Number
                            </label>
                            <input type="tel" class="form-control form-control-lg" id="editUserPhone" name="phone">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-shield me-2"></i>Role *
                            </label>
                            <select class="form-select form-select-lg" id="editUserRole" name="role" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-heart me-2"></i>Birthday
                            </label>
                            <input type="date" class="form-control form-control-lg" id="editUserBirthday" name="birthday">
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

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-circle me-2"></i>User Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsBody">
                <!-- User details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-bakery" onclick="editUserFromDetails()">
                    <i class="bi bi-pencil me-2"></i>Edit User
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
    background: var(--bakery-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.avatar-text {
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
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

.activity-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-detail-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.user-detail-section h6 {
    color: var(--bakery-brown);
    font-weight: 600;
    margin-bottom: 1rem;
    border-bottom: 2px solid var(--bakery-primary);
    padding-bottom: 0.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.05);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    min-width: 120px;
}

.detail-value {
    font-weight: 500;
    color: var(--bakery-brown);
    text-align: right;
    flex-grow: 1;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.stat-mini {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 2px solid rgba(139, 69, 19, 0.1);
    transition: all 0.3s ease;
}

.stat-mini:hover {
    transform: translateY(-3px);
    box-shadow: var(--bakery-shadow);
}

.stat-mini h4 {
    color: var(--bakery-primary);
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-mini p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.9rem;
}
</style>
@endpush

@push('scripts')
<script>
let currentUserId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');

    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;
        const selectedStatus = statusFilter.value;
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const userName = row.querySelector('h6').textContent.toLowerCase();
            const userEmail = row.querySelector('.fw-medium').textContent.toLowerCase();
            const userRole = row.querySelector('.badge').textContent.toLowerCase();
            const userStatus = row.querySelector('td:nth-child(4) .badge').textContent.toLowerCase();

            const matchesSearch = userName.includes(searchTerm) || userEmail.includes(searchTerm);
            const matchesRole = !selectedRole || userRole.includes(selectedRole);
            const matchesStatus = !selectedStatus || userStatus.includes(selectedStatus);

            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterUsers);
    roleFilter.addEventListener('change', filterUsers);
    statusFilter.addEventListener('change', filterUsers);
});

function saveUser() {
    const form = document.getElementById('addUserForm');
    const formData = new FormData(form);
    const submitButton = event.target;

    // Validate required fields
    const name = form.querySelector('[name="name"]').value;
    const email = form.querySelector('[name="email"]').value;
    const password = form.querySelector('[name="password"]').value;
    const passwordConfirmation = form.querySelector('[name="password_confirmation"]').value;
    const role = form.querySelector('[name="role"]').value;

    if (!name || !email || !password || !role) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }

    if (password !== passwordConfirmation) {
        showNotification('Passwords do not match', 'warning');
        return;
    }

    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    submitButton.disabled = true;

    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    fetch('/admin/users', {
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
            showNotification(`User ${data.user.name} created successfully! 👤`, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            form.reset();
            location.reload();
        } else {
            showNotification(data.message || 'Failed to create user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while creating the user', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function editUser(userId) {
    currentUserId = userId;
    
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserPhone').value = user.phone || '';
                document.getElementById('editUserRole').value = user.role;
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

function updateUser() {
    const form = document.getElementById('editUserForm');
    const userId = document.getElementById('editUserId').value;
    const submitButton = event.target;

    const formData = new FormData(form);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    submitButton.disabled = true;

    fetch(`/admin/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`${data.user.name} updated successfully! 📝`, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            location.reload();
        } else {
            showNotification(data.message || 'Failed to update user', 'error');
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

function viewUser(userId) {
    currentUserId = userId;
    
    fetch(`/admin/users/${userId}/stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const stats = data.stats;
                
                const modalBody = document.getElementById('userDetailsBody');
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-detail-section">
                                <h6><i class="bi bi-person-circle me-2"></i>Personal Information</h6>
                                <div class="detail-item">
                                    <span class="detail-label">Name:</span>
                                    <span class="detail-value">${user.name}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value">${user.email}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Role:</span>
                                    <span class="detail-value">
                                        <span class="badge bg-${user.is_admin ? 'danger' : 'primary'}">
                                            ${user.is_admin ? 'Administrator' : 'Customer'}
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Status:</span>
                                    <span class="detail-value">
                                        <span class="badge bg-${user.email_verified_at ? 'success' : 'warning'}">
                                            ${user.email_verified_at ? 'Verified' : 'Pending'}
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Joined:</span>
                                    <span class="detail-value">${new Date(user.created_at).toLocaleDateString()}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-detail-section">
                                <h6><i class="bi bi-graph-up me-2"></i>Activity Statistics</h6>
                                <div class="stats-grid">
                                    <div class="stat-mini">
                                        <h4>${stats.total_orders}</h4>
                                        <p>Total Orders</p>
                                    </div>
                                    <div class="stat-mini">
                                        <h4>Rs. ${stats.total_spent.toLocaleString()}</h4>
                                        <p>Total Spent</p>
                                    </div>
                                    <div class="stat-mini">
                                        <h4>${stats.total_reservations}</h4>
                                        <p>Reservations</p>
                                    </div>
                                    <div class="stat-mini">
                                        <h4>${stats.loyalty_points}</h4>
                                        <p>Loyalty Points</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    ${stats.recent_orders.length > 0 ? `
                        <div class="user-detail-section">
                            <h6><i class="bi bi-receipt me-2"></i>Recent Orders</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${stats.recent_orders.map(order => `
                                            <tr>
                                                <td>#${order.order_id}</td>
                                                <td>${new Date(order.created_at).toLocaleDateString()}</td>
                                                <td>Rs. ${parseFloat(order.total).toFixed(2)}</td>
                                                <td><span class="badge bg-${order.status === 'completed' ? 'success' : 'warning'}">${order.status}</span></td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    ` : ''}
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user details', 'error');
        });
}

function editUserFromDetails() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('userDetailsModal'));
    modal.hide();

    setTimeout(() => {
        editUser(currentUserId);
    }, 300);
}

function deleteUser(userId) {
    const userName = document.querySelector(`[data-user-id="${userId}"] h6`).textContent;

    // Create custom confirmation modal
    const confirmModal = document.createElement('div');
    confirmModal.className = 'modal fade';
    confirmModal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-x text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-center mb-3">Delete "${userName}"?</h5>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action cannot be undone and will permanently remove this user account.
                    </div>
                    <p class="text-muted text-center">Are you absolutely sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteUser(${userId}, '${userName}')" data-bs-dismiss="modal">
                        <i class="bi bi-trash me-2"></i>Yes, Delete User
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(confirmModal);
    const modal = new bootstrap.Modal(confirmModal);
    modal.show();

    // Clean up when modal is hidden
    confirmModal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(confirmModal);
    });
}

function confirmDeleteUser(userId, userName) {
    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`"${userName}" deleted successfully! 🗑️`, 'success');
            
            // Remove the user row from UI
            const row = document.querySelector(`[data-user-id="${userId}"]`);
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                row.remove();
            }, 300);
        } else {
            showNotification(data.message || 'Failed to delete user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function refreshUsers() {
    location.reload();
}

function exportUsers() {
    showNotification('Export functionality coming soon!', 'info');
}
</script>
@endpush