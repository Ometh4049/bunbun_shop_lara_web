+<?php

-        .display-3 {
-            font-size: 2.5rem;
-        }
+namespace App\Http\Controllers;

-        .category-filters {
-            flex-direction: column;
-        }
+use App\Models\Product;
+use App\Models\MenuItem;
+use Illuminate\Http\Request;
+use Illuminate\Support\Facades\Storage;
+use Illuminate\Support\Str;
+use Illuminate\Validation\Rule;
+use Illuminate\Support\Facades\Log;

-        .category-filters .btn {
-            width: 100%;
-            margin: 0.25rem 0;
-        }
+class AdminProductController extends Controller
+{
+    /**
+     * Display the admin products page
+     */
+    public function index()
+    {
+        $products = Product::with('category')
+            ->latest()
+            ->paginate(12);

-        .product-actions {
-            flex-direction: column;
-        }
+        $categories = MenuItem::select('id', 'category')->distinct()->get();

-        .product-actions .btn {
-            width: 100%;
-        }
+        $stats = [
+            'total_products' => Product::count(),
+            'active_products' => Product::where('is_active', true)->count(),
+            'categories_count' => $categories->count(),
+            'avg_price' => Product::avg('price') ?? 0
+        ];

-    /* Ensure equal height cards in each row */
-    .menu-item .card {
-        height: 100%;
-        display: flex;
-        flex-direction: column;
+        return view('admin.products.index', compact('products', 'categories', 'stats'));
     }

-    .menu-item .card-body {
-        flex: 1;
-        display: flex;
-        flex-direction: column;
+    /**
+     * Store a new product
+     */
+    public function store(Request $request)
+    {
+        try {
+            $validatedData = $request->validate([
+                'name' => 'required|string|max:255',
+                'description' => 'nullable|string|max:2000',
+                'price' => 'required|numeric|min:0',
+                'category_id' => 'nullable|exists:menu_items,id',
+                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
+                'image_url' => 'nullable|url',
+                'is_active' => 'boolean',
+            ]);

-    .menu-item .card-text {
-        flex: 1;
+            Log::info('Creating new product', [
+                'name' => $validatedData['name'],
+                'price' => $validatedData['price'],
+                'user_id' => auth()->id()
+            ]);

-    /* Enhanced responsive design */
-    @media (min-width: 1400px) {
-        .container {
-            max-width: 1320px;
-        }
-    }
+            // Handle image upload
+            if ($request->hasFile('image')) {
+                $imagePath = $request->file('image')->store('products', 'public');
+                $validatedData['image_path'] = $imagePath;
+            } elseif ($request->image_url) {
+                // For URL images, we'll store the URL in image_path
+                $validatedData['image_path'] = $request->image_url;
+            }

-    @media (max-width: 1199px) {
-        .product-content {
-            padding: 1.5rem;
-        }
-        
-        .product-image {
-            height: 250px;
-        }
-    }
+            // Generate slug
+            $validatedData['slug'] = Str::slug($validatedData['name']);
+            
+            // Ensure unique slug
+            $originalSlug = $validatedData['slug'];
+            $counter = 1;
+            while (Product::where('slug', $validatedData['slug'])->exists()) {
+                $validatedData['slug'] = $originalSlug . '-' . $counter;
+                $counter++;
+            }

-    @media (max-width: 991px) {
-        .product-image {
-            height: 220px;
-        }
-        
-        .product-content {
-            padding: 1.25rem;
-        }
-        
-        .product-title {
-            font-size: 1.2rem;
-        }
-    }
+            $product = Product::create($validatedData);

-    @media (max-width: 767px) {
-        .menu-hero {
-            min-height: 70vh;
-        }
-        
-        .display-3 {
-            font-size: 2.2rem;
-        }
-        
-        .category-filters {
-            flex-direction: column;
-            align-items: center;
-        }
-        
-        .category-filter-btn {
-            width: 100%;
-            max-width: 280px;
-            margin: 0.25rem 0;
-        }
-        
-        .product-actions {
-            flex-direction: column;
-        }
-        
-        .product-actions .btn {
-            width: 100%;
-        }
-    }
+            Log::info('Product created successfully', [
+                'id' => $product->id,
+                'name' => $product->name
+            ]);

-    @media (max-width: 575px) {
-        .product-content {
-            padding: 1rem;
-        }
-        
-        .product-image {
-            height: 200px;
-        }
-        
-        .search-container .input-group {
-            margin: 0 1rem;
-        }
+            return response()->json([
+                'success' => true,
+                'message' => 'Product created successfully',
+                'product' => $product->load('category')
+            ], 201);

-</style>
-@endpush
+        } catch (\Illuminate\Validation\ValidationException $e) {
+            Log::warning('Product validation failed', [
+                'errors' => $e->errors(),
+                'input' => $request->all()
+            ]);

-@push('scripts')
-<script>
-// Menu Search Functionality
-document.addEventListener('DOMContentLoaded', function() {
-    const searchInput = document.getElementById('menuSearch');
-    const menuItems = document.querySelectorAll('.menu-item');
-    
-    searchInput.addEventListener('input', function() {
-        const searchTerm = this.value.toLowerCase();
-        
-        menuItems.forEach(item => {
-            const title = item.querySelector('.menu-item-title').textContent.toLowerCase();
-            const description = item.querySelector('.menu-item-description').textContent.toLowerCase();
-            const category = item.querySelector('.menu-item-category').textContent.toLowerCase();
-            
-            if (title.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
-                item.style.display = 'block';
-                item.classList.remove('hidden');
-            } else {
-                item.classList.add('hidden');
-                setTimeout(() => {
-                    if (item.classList.contains('hidden')) {
-                        item.style.display = 'none';
-                    }
-                }, 300);
-            }
-        });
-    });
-    
-    // Category Filter Functionality
-    const filterButtons = document.querySelectorAll('.category-filter-btn');
-    
-    filterButtons.forEach(button => {
-        button.addEventListener('click', function() {
-            const category = this.getAttribute('data-category');
-            
-            // Update active button
-            filterButtons.forEach(btn => {
-                btn.classList.remove('active');
-            });
-            this.classList.add('active');
-            
-            // Filter items
-            menuItems.forEach(item => {
-                const itemCategory = item.getAttribute('data-category');
-                
-                if (category === 'all' || itemCategory === category) {
-                    item.style.display = 'block';
-                    item.classList.remove('hidden');
-                } else {
-                    item.classList.add('hidden');
-                    setTimeout(() => {
-                        if (item.classList.contains('hidden')) {
-                            item.style.display = 'none';
-                        }
-                    }, 300);
-                }
-            });
-        });
-    });
-});
+            return response()->json([
+                'success' => false,
+                'message' => 'Validation failed',
+                'errors' => $e->errors()
+            ], 422);
+        } catch (\Exception $e) {
+            Log::error('Product creation failed', [
+                'error' => $e->getMessage(),
+                'trace' => $e->getTraceAsString()
+            ]);

-// Quick Pay functionality
-function quickPay(itemId, itemName, itemPrice, itemImage) {
-    console.log('Quick pay initiated for:', itemName);
+            return response()->json([
+                'success' => false,
+                'message' => 'Failed to create product: ' . $e->getMessage()
+            ], 500);
+        }
+    }

-    // Create single item order data
-    const orderData = {
-        items: [{
-            id: itemId,
-            name: itemName,
-            price: parseFloat(itemPrice),
-            quantity: 1,
-            image: itemImage
-        }],
-        customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
-        customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
-        customer_phone: '',
-        order_type: 'dine_in',
-        subtotal: parseFloat(itemPrice),
-        tax: parseFloat(itemPrice) * 0.1,
-        total: parseFloat(itemPrice) * 1.1,
-        order_id: 'ORD' + Date.now()
-    };
+    /**
+     * Display the specified product
+     */
+    public function show(Product $product)
+    {
+        $product->load('category');
+        
+        return response()->json([
+            'success' => true,
+            'product' => $product
+        ]);
+    }

-    // Store order data globally for payment modal
-    window.currentOrderData = orderData;
+    /**
+     * Update the specified product
+     */
+    public function update(Request $request, Product $product)
+    {
+        try {
+            $validatedData = $request->validate([
+                'name' => 'required|string|max:255',
+                'description' => 'nullable|string|max:2000',
+                'price' => 'required|numeric|min:0',
+                'category_id' => 'nullable|exists:menu_items,id',
+                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
+                'image_url' => 'nullable|url',
+                'is_active' => 'boolean',
+            ]);

-    console.log('Quick pay order data prepared:', orderData);
+            // Handle image upload
+            if ($request->hasFile('image')) {
+                // Delete old image if exists and it's a local file
+                if ($product->image_path && !filter_var($product->image_path, FILTER_VALIDATE_URL)) {
+                    Storage::disk('public')->delete($product->image_path);
+                }

-    // Show payment modal
-    if (typeof showPaymentModal === 'function') {
-        showPaymentModal(orderData);
-    } else {
-        console.error('Payment modal not available');
-        showNotification('Payment system not available', 'error');
+                $imagePath = $request->file('image')->store('products', 'public');
+                $validatedData['image_path'] = $imagePath;
+            } elseif ($request->image_url) {
+                $validatedData['image_path'] = $request->image_url;
+            }
+
+            // Update slug if name changed
+            if ($validatedData['name'] !== $product->name) {
+                $validatedData['slug'] = Str::slug($validatedData['name']);
+                
+                // Ensure unique slug
+                $originalSlug = $validatedData['slug'];
+                $counter = 1;
+                while (Product::where('slug', $validatedData['slug'])->where('id', '!=', $product->id)->exists()) {
+                    $validatedData['slug'] = $originalSlug . '-' . $counter;
+                    $counter++;
+                }
+            }
+
+            $product->update($validatedData);
+
+            Log::info('Product updated successfully', [
+                'id' => $product->id,
+                'changes' => $product->getChanges()
+            ]);
+
+            return response()->json([
+                'success' => true,
+                'message' => 'Product updated successfully',
+                'product' => $product->fresh('category')
+            ]);
+
+        } catch (\Illuminate\Validation\ValidationException $e) {
+            return response()->json([
+                'success' => false,
+                'message' => 'Validation failed',
+                'errors' => $e->errors()
+            ], 422);
+        } catch (\Exception $e) {
+            Log::error('Product update failed: ' . $e->getMessage());
+            return response()->json([
+                'success' => false,
+                'message' => 'Failed to update product: ' . $e->getMessage()
+            ], 500);
+        }
     }
-}

-document.addEventListener('DOMContentLoaded', function() {
-    // Initialize menu functionality
-    initializeMenuFilters();
-    initializeMenuSearch
+    /**
+     * Remove the specified product
+     */
+    public function destroy(Product $product)
+    {
+        try {
+            // Delete image if exists and it's a local file
+            if ($product->image_path && !filter_var($product->image_path, FILTER_VALIDATE_URL)) {
+                Storage::disk('public')->delete($product->image_path);
+            }
+
+            $product->delete();
+
+            Log::info('Product deleted successfully', [
+                'id' => $product->id,
+                'name' => $product->name
+            ]);
+
+            return response()->json([
+                'success' => true,
+                'message' => 'Product deleted successfully'
+            ]);
+        } catch (\Exception $e) {
+            Log::error('Failed to delete product: ' . $e->getMessage());
+            return response()->json([
+                'success' => false,
+                'message' => 'Failed to delete product: ' . $e->getMessage()
+            ], 500);
+        }
+    }
+
+    /**
+     * Toggle product active status
+     */
+    public function toggleStatus(Product $product)
+    {
+        try {
+            $product->update([
+                'is_active' => !$product->is_active
+            ]);
+
+            Log::info('Product status toggled', [
+                'id' => $product->id,
+                'new_status' => $product->is_active
+            ]);
+
+            return response()->json([
+                'success' => true,
+                'message' => 'Product status updated successfully',
+                'product' => $product->fresh('category')
+            ]);
+        } catch (\Exception $e) {
+            Log::error('Failed to toggle product status: ' . $e->getMessage());
+            return response()->json([
+                'success' => false,
+                'message' => 'Failed to update product status: ' . $e->getMessage()
+            ], 500);
+        }
+    }
+
+    /**
+     * Get products for menu display
+     */
+    public function getMenuProducts()
+    {
+        try {
+            $products = Product::active()
+                ->with('category')
+                ->get()
+                ->map(function ($product) {
+                    return [
+                        'id' => $product->id,
+                        'name' => $product->name,
+                        'description' => $product->description,
+                        'price' => $product->price,
+                        'category' => $product->category ? $product->category->category : 'Uncategorized',
+                        'image' => $product->image_url,
+                        'preparation_time' => 'Fresh daily',
+                        'calories' => rand(150, 400),
+                        'status' => 'active'
+                    ];
+                });

-    @media (max-width: 991px) {
-        .product-image {
-            height: 220px;
-        }
-        
-        .product-content {
-            padding: 1.25rem;
-        }
-        
-        .product-title {
-            font-size: 1.2rem;
-        }
+            $categories = MenuItem::select('category')->distinct()->pluck('category');
+
+            return response()->json([
+                'success' => true,
+                'menu_items' => $products,
+                'categories' => $categories
+            ]);
+        } catch (\Exception $e) {
+            Log::error('Failed to fetch menu products: ' . $e->getMessage());
+            return response()->json([
+                'success' => false,
+                'message' => 'Failed to fetch menu products: ' . $e->getMessage()
+            ], 500);
+        }
     }
+}
+