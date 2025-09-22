@extends('layouts.admin')

@section('title', 'Products Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Products Management</h1>
            <p class="mb-0 text-muted">Manage bakery products and inventory</p>
        </div>
        <div>
            <button class="btn btn-bakery" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Product
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsGrid">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 product-card" data-product-id="{{ $product->id }}">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($product->category)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-primary">{{ $product->category->category }}</span>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title text-bakery">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 text-bakery mb-0">{{ $product->formatted_price }}</span>
                        <small class="text-muted">{{ $product->formatted_created_at }}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewProduct({{ $product->id }})" title="View Details">
                                <i class="bi bi-info-circle"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editProduct({{ $product->id }})" title="Edit Product">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-{{ $product->is_active ? 'warning' : 'success' }}"
                                    onclick="toggleStatus({{ $product->id }}, {{ $product->is_active ? 'true' : 'false' }})"
                                    title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="bi bi-{{ $product->is_active ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteProduct({{ $product->id }})" title="Delete Product">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-box text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">No products found</h4>
        <p class="text-muted">Start by adding your first product!</p>
        <button class="btn btn-bakery" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle me-2"></i>Add First Product
        </button>
    </div>
    @endif

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bakery text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rs.) *</label>
                            <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Supported formats: JPG, PNG, GIF (Max: 2MB)</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-bakery" onclick="saveProduct()">
                    <i class="bi bi-check-lg me-2"></i>Save Product
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editProductId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rs.) *</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" id="editProductCategory" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="editProductStatus" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="editProductDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Image</label>
                            <div class="mb-2">
                                <img id="currentProductImage" src="" alt="Current Image" class="img-thumbnail" style="max-width: 200px; display: none;">
                            </div>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="updateProduct()">
                    <i class="bi bi-check-lg me-2"></i>Update Product
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);
    const submitButton = event.target;

    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    submitButton.disabled = true;

    fetch('/admin/products', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product created successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
            form.reset();
            location.reload();
        } else {
            showNotification('Failed to create product', 'error');
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

function editProduct(productId) {
    fetch(`/admin/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                
                document.getElementById('editProductId').value = product.id;
                document.getElementById('editProductName').value = product.name;
                document.getElementById('editProductPrice').value = product.price;
                document.getElementById('editProductCategory').value = product.category_id || '';
                document.getElementById('editProductStatus').value = product.is_active ? '1' : '0';
                document.getElementById('editProductDescription').value = product.description || '';
                
                const currentImage = document.getElementById('currentProductImage');
                if (product.image_url) {
                    currentImage.src = product.image_url;
                    currentImage.style.display = 'block';
                } else {
                    currentImage.style.display = 'none';
                }
                
                const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load product data', 'error');
        });
}

function updateProduct() {
    const form = document.getElementById('editProductForm');
    const formData = new FormData(form);
    const productId = document.getElementById('editProductId').value;
    const submitButton = event.target;

    formData.append('_method', 'PUT');

    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    submitButton.disabled = true;

    fetch(`/admin/products/${productId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product updated successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
            modal.hide();
            location.reload();
        } else {
            showNotification('Failed to update product', 'error');
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

function viewProduct(productId) {
    fetch(`/admin/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                alert(`Product: ${product.name}\nPrice: ${product.formatted_price}\nStatus: ${product.is_active ? 'Active' : 'Inactive'}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load product details', 'error');
        });
}

function toggleStatus(productId, currentStatus) {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;

    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    button.disabled = true;

    fetch(`/admin/products/${productId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product status updated successfully!', 'success');
            location.reload();
        } else {
            showNotification('Failed to update product status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function deleteProduct(productId) {
    if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product deleted successfully!', 'success');
            
            // Remove the product card from UI
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                card.remove();
            }, 300);
        } else {
            showNotification('Failed to delete product', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}
</script>
@endpush