@extends('layouts.admin')

@section('title', 'Settings - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-gear me-3 text-bakery"></i>
                    Bakery Settings
                </h1>
                <p class="lead text-muted mb-0">Manage bakery settings and configurations</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- General Settings -->
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">General Settings</h5>
                </div>
                <div class="card-body">
                    <form id="generalSettings">
                        <div class="row g-3">
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-shop me-2"></i>Bakery Name
                                    </label>
                                    <input type="text" class="form-control form-control-lg" value="{{ $settings['cafe_name'] }}">
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Contact Email
                                    </label>
                                    <input type="email" class="form-control form-control-lg" value="{{ $settings['contact_email'] }}">
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-2"></i>Contact Phone
                                    </label>
                                    <input type="tel" class="form-control form-control-lg" value="{{ $settings['contact_phone'] }}">
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-people me-2"></i>Max Reservation Guests
                                    </label>
                                    <input type="number" class="form-control form-control-lg" value="{{ $settings['max_reservation_guests'] }}">
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-sunrise me-2"></i>Opening Time
                                    </label>
                                    <input type="time" class="form-control form-control-lg" value="{{ $settings['opening_time'] }}">
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-sunset me-2"></i>Closing Time
                                    </label>
                                    <input type="time" class="form-control form-control-lg" value="{{ $settings['closing_time'] }}">
                            </div>
                            <div class="col-12">
                                    <button type="submit" class="btn btn-bakery btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Settings -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Notification Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">
                                        <i class="bi bi-envelope me-2"></i>
                                    Email Notifications for New Reservations
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="smsNotifications">
                                <label class="form-check-label" for="smsNotifications">
                                        <i class="bi bi-phone me-2"></i>
                                    SMS Notifications for Order Updates
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                                <label class="form-check-label" for="pushNotifications">
                                        <i class="bi bi-bell me-2"></i>
                                    Push Notifications for Admin Panel
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                            <button class="btn btn-outline-bakery">
                            <i class="bi bi-download me-2"></i>Export Data
                        </button>
                            <button class="btn btn-outline-bakery">
                            <i class="bi bi-upload me-2"></i>Import Menu Items
                        </button>
                            <button class="btn btn-outline-bakery">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Cache
                        </button>
                            <button class="btn btn-outline-bakery">
                            <i class="bi bi-shield-check me-2"></i>Run Security Scan
                        </button>
                            <button class="btn btn-outline-bakery">
                            <i class="bi bi-database me-2"></i>Backup Database
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Info -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">System Information</h5>
                </div>
                <div class="card-body">
                        <div class="system-info">
                            <div class="info-item">
                                <span class="info-label">Version:</span>
                                <span class="info-value">1.0.0</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Laravel:</span>
                                <span class="info-value">11.x</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">PHP:</span>
                                <span class="info-value">8.2</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Database:</span>
                                <span class="info-value">SQLite</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Backup:</span>
                                <span class="info-value text-success">2 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.system-info {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
}

.info-value {
    font-weight: 600;
    color: var(--bakery-brown);
}

.form-check-input:checked {
    background-color: var(--bakery-primary);
    border-color: var(--bakery-primary);
}

.form-check-input:focus {
    border-color: var(--bakery-primary);
    box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
}

.form-check-label {
    font-weight: 500;
    color: var(--bakery-brown);
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('generalSettings').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Saved!';
        button.classList.remove('btn-bakery');
        button.classList.add('btn-success');
        
        showNotification('Settings saved successfully! ⚙️', 'success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-success');
            button.classList.add('btn-bakery');
        }, 2000);
    }, 1000);
});

// Quick action handlers
document.querySelectorAll('.btn-outline-bakery').forEach(button => {
    button.addEventListener('click', function() {
        const action = this.textContent.trim();
        const originalText = this.innerHTML;
        
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        this.disabled = true;
        
        setTimeout(() => {
            this.innerHTML = originalText;
            this.disabled = false;
            showNotification(`${action} functionality coming soon! 🚀`, 'info');
        }, 1500);
    });
});
</script>
@endpush
                        <tr>
                            <td><strong>Version:</strong></td>
                            <td>1.0.0</td>
                        </tr>
                        <tr>
                            <td><strong>Laravel:</strong></td>
                            <td>11.x</td>
                        </tr>
                        <tr>
                            <td><strong>PHP:</strong></td>
                            <td>8.2</td>
                        </tr>
                        <tr>
                            <td><strong>Database:</strong></td>
                            <td>SQLite</td>
                        </tr>
                        <tr>
                            <td><strong>Last Backup:</strong></td>
                            <td>2 hours ago</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('generalSettings').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Settings saved successfully!');
});
</script>
@endpush