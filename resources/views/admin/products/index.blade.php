@extends('layouts.admin')

@section('title', 'Products Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
        <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="bi bi-box-seam me-3 text-bakery"></i>
                    Products Management
                </h1>
                <p class="lead text-muted mb-0">Manage bakery products and inventory</p>
        </div>
        <div>
            <button class="btn btn-bakery" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Product
            </button>
        </div>
        </div>
    </div>

    <!-- Product Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="totalProductsCount">{{ $products->total() }}</h3>
                    <p class="text-muted mb-0">Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="activeProductsCount">{{ $products->where('is_active', true)->count() }}</h3>
                    <p class="text-muted mb-0">Active Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="categoriesCount">{{ $categories->count() }}</h3>
                    <p class="text-muted mb-0">Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-bakery" id="avgPriceDisplay">Rs. {{ number_format($products->avg('price') ?? 0, 0) }}</h3>
                    <p class="text-muted mb-0">Avg. Price</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-bakery w-100" onclick="exportProducts()">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsGrid">
        @foreach($products as $product)
            <div class="col-lg-4 col-md-6 product-card" data-product-id="{{ $product->id }}" data-category="{{ $product->category_id }}" data-status="{{ $product->is_active ? '1' : '0' }}">
                <div class="card h-100 product-item">
                <div class="position-relative">
                        <img src="{{ $product->image_url }}" class="card-img-top product-image" alt="{{ $product->name }}">
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
                        <h5 class="card-title text-bakery fw-bold">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h4 text-bakery mb-0 fw-bold">{{ $product->formatted_price }}</span>
                        <small class="text-muted">{{ $product->formatted_created_at }}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-info" onclick="viewProduct({{ $product->id }})" title="View Details">
                                <i class="bi bi-info-circle"></i>
                            </button>
                                <button class="btn btn-outline-bakery" onclick="editProduct({{ $product->id }})" title="Edit Product">
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
        <div class="empty-state">
            <div class="text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="bi bi-box text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">No products found</h3>
                <p class="text-muted mb-4">Start by adding your first bakery product!</p>
                <button class="btn btn-bakery btn-lg" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-circle me-2"></i>Add First Product
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        </div>
    @endif
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
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="text-bakery mb-3 fw-bold">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h6>
                            </div>

                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tag me-2"></i>Product Name *
                                </label>
                                <input type="text" class="form-control form-control-lg" name="name" required placeholder="e.g., Chocolate Croissant">
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-currency-dollar me-2"></i>Price (Rs.) *
                                </label>
                                <input type="number" class="form-control form-control-lg" name="price" step="0.01" min="0" required placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-grid-3x3-gap me-2"></i>Category
                                </label>
                                <select class="form-select form-select-lg" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-toggle-on me-2"></i>Status
                                </label>
                                <select class="form-select form-select-lg" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                            <!-- Description -->
                            <div class="col-12 mt-4">
                                <h6 class="text-bakery mb-3 fw-bold">
                                    <i class="bi bi-card-text me-2"></i>Product Details
                                </h6>
                            </div>

                        <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-text me-2"></i>Description
                                </label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Enter a detailed description of the product..."></textarea>
                        </div>

                            <!-- Image Upload -->
                            <div class="col-12 mt-4">
                                <h6 class="text-bakery mb-3 fw-bold">
                                    <i class="bi bi-image me-2"></i>Product Image
                                </h6>
                            </div>

                        <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-upload me-2"></i>Upload Image
                                </label>
                                <input type="file" class="form-control form-control-lg" name="image" accept="image/*">
                                <small class="text-muted">Supported formats: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>

                            <!-- Preview Section -->
                            <div class="col-12">
                                <div class="preview-section" id="imagePreviewSection" style="display: none;">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-eye me-2"></i>Image Preview
                                    </label>
                                    <div class="preview-container">
                                        <img id="imagePreview" src="" alt="Preview" class="preview-image">
                                        <button type="button" class="btn btn-sm btn-outline-danger preview-remove" onclick="removeImagePreview()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
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
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="text-warning mb-3 fw-bold">
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h6>
                            </div>

                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tag me-2"></i>Product Name *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="editProductName" name="name" required>
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-currency-dollar me-2"></i>Price (Rs.) *
                                </label>
                                <input type="number" class="form-control form-control-lg" id="editProductPrice" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-grid-3x3-gap me-2"></i>Category
                                </label>
                                <select class="form-select form-select-lg" id="editProductCategory" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-toggle-on me-2"></i>Status
                                </label>
                                <select class="form-select form-select-lg" id="editProductStatus" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                            <!-- Description -->
                            <div class="col-12 mt-4">
                                <h6 class="text-warning mb-3 fw-bold">
                                    <i class="bi bi-card-text me-2"></i>Product Details
                                </h6>
                            </div>

                        <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-text me-2"></i>Description
                                </label>
                            <textarea class="form-control" id="editProductDescription" name="description" rows="3"></textarea>
                        </div>

                            <!-- Image Upload -->
                            <div class="col-12 mt-4">
                                <h6 class="text-warning mb-3 fw-bold">
                                    <i class="bi bi-image me-2"></i>Product Image
                                </h6>
                            </div>

                        <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image me-2"></i>Current Image
                                </label>
                            <div class="mb-2">
                                    <img id="currentProductImage" src="" alt="Current Image" class="current-product-image" style="display: none;">
                            </div>
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-upload me-2"></i>Upload New Image
                                </label>
                                <input type="file" class="form-control form-control-lg" name="image" accept="image/*">
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

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Product Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="productDetailsBody">
                <!-- Product details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-bakery" onclick="editProductFromDetails()">
                    <i class="bi bi-pencil me-2"></i>Edit Product
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentProductId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('productSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const selectedStatus = statusFilter.value;
        const products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            const productName = product.querySelector('.card-title').textContent.toLowerCase();
            const productCategory = product.getAttribute('data-category');
            const productStatus = product.getAttribute('data-status');

            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !selectedCategory || productCategory === selectedCategory;
            const matchesStatus = !selectedStatus || productStatus === selectedStatus;

            if (matchesSearch && matchesCategory && matchesStatus) {
                product.style.display = 'block';
                product.style.opacity = '1';
                product.style.transform = 'scale(1)';
            } else {
                product.style.opacity = '0';
                product.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    if (product.style.opacity === '0') {
                        product.style.display = 'none';
                    }
                }, 300);
            }
        });
    }

    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    statusFilter.addEventListener('change', filterProducts);

    // Image preview functionality
    const imageInput = document.querySelector('input[name="image"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    showNotification('Please select a valid image file.', 'warning');
                    this.value = '';
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Image size must be less than 2MB.', 'warning');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    showImagePreview();
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

function showImagePreview() {
    const previewSection = document.getElementById('imagePreviewSection');
    previewSection.style.display = 'block';
    previewSection.style.opacity = '0';
    previewSection.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        previewSection.style.transition = 'all 0.3s ease';
        previewSection.style.opacity = '1';
        previewSection.style.transform = 'translateY(0)';
    }, 100);
}

function removeImagePreview() {
    const imageInput = document.querySelector('input[name="image"]');
    const previewSection = document.getElementById('imagePreviewSection');
    
    imageInput.value = '';
    previewSection.style.transition = 'all 0.3s ease';
    previewSection.style.opacity = '0';
    previewSection.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        previewSection.style.display = 'none';
    }, 300);
}

function saveProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);
    const submitButton = event.target;

    // Validate required fields
    const name = form.querySelector('[name="name"]').value;
    const price = form.querySelector('[name="price"]').value;

    if (!name || !price) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }

    if (parseFloat(price) <= 0) {
        showNotification('Price must be greater than 0', 'warning');
        return;
    }

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
                showNotification(`${data.product.name} created successfully! ✨`, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
            form.reset();
                
                // Add new product to grid instead of reloading
                addProductToGrid(data.product);
                updateProductStats();
        } else {
                showNotification(data.message || 'Failed to create product', 'error');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
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

function addProductToGrid(product) {
    const productsGrid = document.getElementById('productsGrid');
    if (!productsGrid) return;

    const productCard = createProductCard(product);
    productsGrid.insertAdjacentHTML('afterbegin', productCard);

    // Animate the new product
    const newCard = productsGrid.firstElementChild;
    newCard.style.opacity = '0';
    newCard.style.transform = 'scale(0.8)';

    setTimeout(() => {
        newCard.style.transition = 'all 0.3s ease';
        newCard.style.opacity = '1';
        newCard.style.transform = 'scale(1)';
    }, 100);
}

function createProductCard(product) {
    return `
        <div class="col-lg-4 col-md-6 product-card" data-product-id="${product.id}" data-category="${product.category_id || ''}" data-status="${product.is_active ? '1' : '0'}">
            <div class="card h-100 product-item">
                <div class="position-relative">
                    <img src="${product.image_url || 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop'}" class="card-img-top product-image" alt="${product.name}">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-${product.is_active ? 'success' : 'secondary'}">
                            ${product.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                    ${product.category ? `
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-primary">${product.category.category}</span>
                        </div>
                    ` : ''}
                </div>
                <div class="card-body">
                    <h5 class="card-title text-bakery fw-bold">${product.name}</h5>
                    <p class="card-text text-muted">${product.description ? (product.description.length > 100 ? product.description.substring(0, 100) + '...' : product.description) : 'No description'}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h4 text-bakery mb-0 fw-bold">Rs. ${parseFloat(product.price).toFixed(2)}</span>
                        <small class="text-muted">Just added</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewProduct(${product.id})" title="View Details">
                                <i class="bi bi-info-circle"></i>
                            </button>
                            <button class="btn btn-outline-bakery" onclick="editProduct(${product.id})" title="Edit Product">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-${product.is_active ? 'warning' : 'success'}"
                                    onclick="toggleStatus(${product.id}, ${product.is_active ? 'true' : 'false'})"
                                    title="${product.is_active ? 'Deactivate' : 'Activate'}">
                                <i class="bi bi-${product.is_active ? 'eye-slash' : 'eye'}"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteProduct(${product.id})" title="Delete Product">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function updateProductStats() {
    const totalCount = document.querySelectorAll('.product-card').length;
    const activeCount = document.querySelectorAll('.product-card[data-status="1"]').length;
    
    document.getElementById('totalProductsCount').textContent = totalCount;
    document.getElementById('activeProductsCount').textContent = activeCount;
}

function editProduct(productId) {
    currentProductId = productId;
    
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
                showNotification(`${data.product.name} updated successfully! 📝`, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
            modal.hide();
                
                // Update the product in the grid
                updateProductInGrid(data.product);
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

function updateProductInGrid(product) {
    const existingCard = document.querySelector(`[data-product-id="${product.id}"]`);
    if (!existingCard) return;

    const newCard = createProductCard(product);
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = newCard;

    existingCard.outerHTML = tempDiv.firstElementChild.outerHTML;
}

function viewProduct(productId) {
    currentProductId = productId;
    
    fetch(`/admin/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                    
                    const modalBody = document.getElementById('productDetailsBody');
                    modalBody.innerHTML = `
                        <div class="row">
                            <div class="col-md-5">
                                <img src="${product.image_url || 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop'}"
                                     class="img-fluid rounded product-detail-image" alt="${product.name}">
                            </div>
                            <div class="col-md-7">
                                <h3 class="text-bakery fw-bold">${product.name}</h3>
                                <p class="text-muted">${product.description || 'No description available'}</p>

                                <div class="product-details-table">
                                    <div class="detail-row">
                                        <span class="detail-label">Price:</span>
                                        <span class="detail-value">Rs. ${parseFloat(product.price).toFixed(2)}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Category:</span>
                                        <span class="detail-value">${product.category ? product.category.category : 'No category'}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Status:</span>
                                        <span class="detail-value">
                                            <span class="badge bg-${product.is_active ? 'success' : 'secondary'}">
                                                ${product.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Created:</span>
                                        <span class="detail-value">${new Date(product.created_at).toLocaleDateString()}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Updated:</span>
                                        <span class="detail-value">${new Date(product.updated_at).toLocaleDateString()}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
                    modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load product details', 'error');
        });
}

function editProductFromDetails() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('productDetailsModal'));
    modal.hide();

    setTimeout(() => {
        editProduct(currentProductId);
    }, 300);
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
                showNotification(`Product status updated successfully! ${data.product.is_active ? '✅' : '⏸️'}`, 'success');
                
                // Update the button and badge in the UI
                const card = button.closest('.product-card');
                const statusBadge = card.querySelector('.badge');
                const newStatus = data.product.is_active;

                // Update status badge
                statusBadge.className = `badge bg-${newStatus ? 'success' : 'secondary'}`;
                statusBadge.textContent = newStatus ? 'Active' : 'Inactive';

                // Update button
                button.className = `btn btn-outline-${newStatus ? 'warning' : 'success'} btn-sm`;
                button.innerHTML = `<i class="bi bi-${newStatus ? 'eye-slash' : 'eye'}"></i>`;
                button.title = newStatus ? 'Deactivate' : 'Activate';

                // Update data attribute
                card.setAttribute('data-status', newStatus ? '1' : '0');
                
                updateProductStats();
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
    // Enhanced confirmation dialog
    const productName = document.querySelector(`[data-product-id="${productId}"] .card-title`).textContent;

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
                        <i class="bi bi-trash text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-center mb-3">Delete "${productName}"?</h5>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action cannot be undone and will permanently remove this product.
                    </div>
                    <p class="text-muted text-center">Are you absolutely sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteProduct(${productId}, '${productName}')" data-bs-dismiss="modal">
                        <i class="bi bi-trash me-2"></i>Yes, Delete Product
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

function confirmDeleteProduct(productId, productName) {
    fetch(`/admin/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`"${productName}" deleted successfully! 🗑️`, 'success');
            
            // Remove the product card from UI
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                card.remove();
                updateProductStats();
                
                // Check if no products left
                const remainingProducts = document.querySelectorAll('.product-card');
                if (remainingProducts.length === 0) {
                    location.reload(); // Reload to show empty state
                }
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

function exportProducts() {
    showNotification('Export functionality coming soon!', 'info');
}
</script>
@endpush

@push('styles')
<style>
.product-image {
    height: 220px;
    object-fit: cover;
    transition: all 0.4s ease;
}

.product-item:hover .product-image {
    transform: scale(1.05);
}

.product-item {
    transition: all 0.3s ease;
    border-radius: 20px;
    overflow: hidden;
}

.product-item:hover {
    transform: translateY(-8px);
    box-shadow: var(--bakery-shadow-hover);
}

.empty-state {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    padding: 3rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.empty-icon {
    font-size: 5rem;
    opacity: 0.5;
}

.preview-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.preview-container {
    position: relative;
    display: inline-block;
}

.preview-image {
    max-width: 200px;
    max-height: 150px;
    border-radius: 15px;
    box-shadow: var(--bakery-shadow);
}

.preview-remove {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-product-image {
    max-width: 200px;
    max-height: 150px;
    border-radius: 15px;
    box-shadow: var(--bakery-shadow);
}

.product-detail-image {
    border-radius: 15px;
    box-shadow: var(--bakery-shadow);
}

.product-details-table {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.1);
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

.pagination-wrapper {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem;
    border: 2px solid rgba(139, 69, 19, 0.1);
}

.pagination .page-link {
    border: none;
    border-radius: 10px;
    margin: 0 0.25rem;
    color: var(--bakery-primary);
    font-weight: 500;
}

.pagination .page-link:hover {
    background: var(--bakery-primary);
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: var(--bakery-primary);
    border-color: var(--bakery-primary);
}
</style>
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