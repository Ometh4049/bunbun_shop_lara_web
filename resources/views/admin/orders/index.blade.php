@extends('layouts.admin')

@section('title', 'Orders - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
        <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-receipt me-3 text-bakery"></i>
                    Orders Management
                </h1>
                <p class="lead text-muted mb-0">Manage customer orders and track sales</p>
        </div>
        <div>
            <button class="btn btn-coffee">
                <i class="bi bi-plus-circle me-2"></i>New Order
            </button>
        </div>
        </div>
    </div>

    <!-- Order Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
                <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-receipt"></i>
                    </div>
                        <h3 class="mb-0 fw-bold text-bakery">47</h3>
                        <p class="text-muted mb-0">Today's Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                        <h3 class="mb-0 fw-bold text-bakery">12</h3>
                        <p class="text-muted mb-0">Preparing</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                        <h3 class="mb-0 fw-bold text-bakery">35</h3>
                        <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                        <h3 class="mb-0 fw-bold text-bakery">Rs. 45,200</h3>
                        <p class="text-muted mb-0">Today's Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
        <div class="card">
            <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Orders</h5>
                <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Preparing</option>
                        <option>Ready</option>
                        <option>Completed</option>
                    </select>
                        <button class="btn btn-outline-bakery btn-sm">
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
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                    <span class="fw-bold text-bakery">#{{ $order->order_id ?? 'ORD' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div>
                                        <h6 class="mb-0 fw-semibold">{{ $order->customer_name }}</h6>
                                        <small class="text-muted">{{ $order->user ? 'Registered Customer' : 'Walk-in Customer' }}</small>
                                </div>
                            </td>
                            <td>
                                    <span class="fw-medium">{{ is_array($order->items) ? count($order->items) . ' items' : $order->items }}</span>
                            </td>
                            <td>
                                    <span class="fw-bold text-bakery">Rs. {{ number_format($order->total, 2) }}</span>
                            </td>
                            <td>
                                @if($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status == 'preparing')
                                    <span class="badge bg-warning">Preparing</span>
                                @elseif($order->status == 'ready')
                                    <span class="badge bg-info">Ready</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                    <span>{{ $order->created_at->format('M d, Y') }}</span><br>
                                    <small class="text-muted">{{ $order->created_at->format('g:i A') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($order->status == 'preparing')
                                            <button class="btn btn-success" onclick="markReady('{{ $order->order_id ?? $order->id }}')">
                                            <i class="bi bi-check"></i> Ready
                                        </button>
                                    @elseif($order->status == 'ready')
                                            <button class="btn btn-primary" onclick="markCompleted('{{ $order->order_id ?? $order->id }}')">
                                            <i class="bi bi-check-all"></i> Complete
                                        </button>
                                    @elseif($order->status == 'pending')
                                            <button class="btn btn-warning" onclick="confirmOrder('{{ $order->order_id ?? $order->id }}')">
                                            <i class="bi bi-check"></i>
                                        </button>
                                            <button class="btn btn-danger" onclick="cancelOrder('{{ $order->order_id ?? $order->id }}')">
                                                <i class="bi bi-x"></i>
                                        </button>
                                    @endif
                                        <button class="btn btn-outline-secondary" onclick="viewOrder('{{ $order->order_id ?? $order->id }}')">
                                            <i class="bi bi-eye"></i>
                                    </button>
                                        <button class="btn btn-outline-primary" onclick="printReceipt('{{ $order->order_id ?? $order->id }}')">
                                            <i class="bi bi-printer"></i>
                                    </button>
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

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt me-2"></i>Order Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <!-- Order details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-bakery">
                        <i class="bi bi-printer me-2"></i>Print Receipt
                    </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmOrder(orderId) {
    if (confirm('Confirm this order?')) {
        updateOrderStatus(orderId, 'confirmed');
    }
}

function cancelOrder(orderId) {
    if (confirm('Cancel this order? This action cannot be undone.')) {
        updateOrderStatus(orderId, 'cancelled');
    }
}

function markReady(orderId) {
    if (confirm('Mark this order as ready for pickup?')) {
        updateOrderStatus(orderId, 'ready');
    }
}

function markCompleted(orderId) {
    if (confirm('Mark this order as completed?')) {
        updateOrderStatus(orderId, 'completed');
    }
}

function updateOrderStatus(orderId, status) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    button.disabled = true;

    fetch(`/admin/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
                showNotification(`Order status updated to ${status}! 📋`, 'success');
            
            // Update the status badge in the table
            const row = button.closest('tr');
            const statusBadge = row.querySelector('.badge');
            if (statusBadge) {
                statusBadge.className = `badge bg-${getStatusColor(status)}`;
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            }
            
            // Update action buttons
            updateActionButtons(row, status);
        } else {
            showNotification('Failed to update order status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating the order', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function getStatusColor(status) {
    const colors = {
        'pending': 'secondary',
        'confirmed': 'info',
        'preparing': 'warning',
        'ready': 'primary',
        'completed': 'success',
        'cancelled': 'danger'
    };
    return colors[status] || 'secondary';
}

function updateActionButtons(row, status) {
    const actionsCell = row.querySelector('.btn-group');
    let buttonsHtml = '';
    
        const orderIdElement = row.querySelector('.fw-bold');
        const orderId = orderIdElement.textContent.replace('#', '');
    
    if (status === 'confirmed') {
        buttonsHtml = `
                <button class="btn btn-warning" onclick="updateOrderStatus('${orderId}', 'preparing')">
                <i class="bi bi-clock"></i> Start Preparing
            </button>
        `;
    } else if (status === 'preparing') {
        buttonsHtml = `
                <button class="btn btn-success" onclick="markReady('${orderId}')">
                <i class="bi bi-check"></i> Ready
            </button>
        `;
    } else if (status === 'ready') {
        buttonsHtml = `
                <button class="btn btn-primary" onclick="markCompleted('${orderId}')">
                <i class="bi bi-check-all"></i> Complete
            </button>
        `;
    }
    
    // Always add view and print buttons
    buttonsHtml += `
            <button class="btn btn-outline-secondary" onclick="viewOrder('${orderId}')">
            <i class="bi bi-eye"></i>
        </button>
            <button class="btn btn-outline-primary" onclick="printReceipt('${orderId}')">
            <i class="bi bi-printer"></i>
        </button>
    `;
    
    actionsCell.innerHTML = buttonsHtml;
}

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
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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

function viewOrder(orderId) {
    const modalBody = document.getElementById('orderModalBody');
        modalBody.innerHTML = `
            <div class="order-detail-section">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-bakery fw-bold mb-3">
                            <i class="bi bi-info-circle me-2"></i>Order Information
                        </h6>
                        <div class="detail-table">
                            <div class="detail-row">
                                <span class="detail-label">Order ID:</span>
                                <span class="detail-value">#${orderId}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Customer:</span>
                                <span class="detail-value">Sample Customer</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Order Time:</span>
                                <span class="detail-value">2:30 PM</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">
                                    <span class="badge bg-success">Completed</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-bakery fw-bold mb-3">
                            <i class="bi bi-basket me-2"></i>Order Items
                        </h6>
                        <div class="order-items">
                            <div class="order-item">
                                <div class="d-flex justify-content-between">
                                    <span>Cappuccino x2</span>
                                    <span class="fw-bold">Rs. 960.00</span>
                                </div>
                            </div>
                            <div class="order-item">
                                <div class="d-flex justify-content-between">
                                    <span>Croissant x1</span>
                                    <span class="fw-bold">Rs. 280.00</span>
                                </div>
                            </div>
                            <div class="order-total">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total:</span>
                                    <span class="fw-bold text-bakery">Rs. 1,240.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="text-bakery fw-bold mb-3">
                        <i class="bi bi-chat-square-text me-2"></i>Special Instructions
                    </h6>
                    <div class="special-instructions">
                        <p class="text-muted">Extra hot cappuccino, no sugar.</p>
                    </div>
                </div>
            </div>
        `;
    
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    modal.show();
}

function printReceipt(orderId) {
        showNotification('Receipt printing functionality coming soon! 🖨️', 'info');
}

function deleteOrder(orderId) {
    if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/orders/${orderId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
                showNotification('Order deleted successfully! 🗑️', 'success');
            // Remove the row from table
            const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
            if (row) {
                row.remove();
            }
        } else {
            showNotification('Failed to delete order', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while deleting the order', 'error');
    });
}

// Auto-refresh orders every 30 seconds
setInterval(function() {
    refreshOrdersTable();
}, 30000);

function refreshOrdersTable() {
    fetch('/admin/api/orders')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update orders table with new data
                console.log('Orders refreshed');
            }
        })
        .catch(error => {
            console.error('Failed to refresh orders:', error);
        });
}

function updateOrderInTable(orderData) {
    const row = document.querySelector(`tr[data-order-id="${orderData.id}"]`);
    if (row) {
        // Update status badge
        const statusCell = row.querySelector('td:nth-child(5)');
        if (statusCell) {
            let badgeClass = 'bg-secondary';
            switch(orderData.status) {
                case 'completed': badgeClass = 'bg-success'; break;
                case 'preparing': badgeClass = 'bg-warning'; break;
                case 'ready': badgeClass = 'bg-info'; break;
                case 'confirmed': badgeClass = 'bg-primary'; break;
                case 'cancelled': badgeClass = 'bg-danger'; break;
            }
            statusCell.innerHTML = `<span class="badge ${badgeClass}">${orderData.status.charAt(0).toUpperCase() + orderData.status.slice(1)}</span>`;
        }
        
        // Update action buttons based on new status
        updateOrderActionButtons(row, orderData.status, orderData.id);
        
        // Add visual feedback
        row.style.backgroundColor = '#d1ecf1';
        setTimeout(() => {
            row.style.backgroundColor = '';
        }, 2000);
    }
}

function updateOrderActionButtons(row, status, orderId) {
    const actionsCell = row.querySelector('td:nth-child(7) .btn-group');
    if (!actionsCell) return;
    
    let buttonsHtml = '';
    
    if (status === 'pending') {
        buttonsHtml += `
                <button class="btn btn-success" onclick="confirmOrder('${orderId}')">
                <i class="bi bi-check"></i>
            </button>
                <button class="btn btn-danger" onclick="cancelOrder('${orderId}')">
                <i class="bi bi-x"></i>
            </button>
        `;
    } else if (status === 'preparing') {
        buttonsHtml += `
                <button class="btn btn-success" onclick="markReady('${orderId}')">
                <i class="bi bi-check"></i>
            </button>
        `;
    } else if (status === 'ready') {
        buttonsHtml += `
                <button class="btn btn-primary" onclick="markCompleted('${orderId}')">
                <i class="bi bi-check-all"></i>
            </button>
        `;
    }
    
    // Always add view, edit, and delete buttons
    buttonsHtml += `
            <button class="btn btn-outline-secondary" onclick="viewOrder('${orderId}')">
            <i class="bi bi-eye"></i>
        </button>
            <button class="btn btn-outline-primary" onclick="printReceipt('${orderId}')">
                <i class="bi bi-printer"></i>
        </button>
    `;
    
    actionsCell.innerHTML = buttonsHtml;
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
    
    .order-detail-section {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 15px;
        padding: 2rem;
        border: 2px solid rgba(139, 69, 19, 0.1);
    }
    
    .detail-table {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #6c757d;
    }
    
    .detail-value {
        font-weight: 600;
        color: var(--bakery-brown);
    }
    
    .order-items {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }
    
    .order-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid var(--bakery-primary);
    }
    
    .special-instructions {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }
`;
document.head.appendChild(style);
</script>
@endpush