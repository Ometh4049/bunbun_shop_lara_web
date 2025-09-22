<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(12);

        $categories = MenuItem::select('id', 'category')->distinct()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = MenuItem::select('id', 'category')->distinct()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:menu_items,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        // Generate slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Ensure unique slug
        $originalSlug = $validatedData['slug'];
        $counter = 1;
        while (Product::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $product = Product::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('category')
        ], 201);
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load('category');
        
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $categories = MenuItem::select('id', 'category')->distinct()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:menu_items,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        // Update slug if name changed
        if ($validatedData['name'] !== $product->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            
            // Ensure unique slug
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Product::where('slug', $validatedData['slug'])->where('id', '!=', $product->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $product->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product->fresh('category')
        ]);
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Toggle product active status
     */
    public function toggleStatus(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully',
            'product' => $product->fresh('category')
        ]);
    }

    /**
     * Get products by category
     */
    public function byCategory($categoryId)
    {
        $products = Product::active()
            ->where('category_id', $categoryId)
            ->with('category')
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
}