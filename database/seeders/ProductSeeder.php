+<?php

-    document.body.appendChild(notification);
+namespace Database\Seeders;

-    setTimeout(() => {
-        if (notification.parentElement) {
-            notification.style.animation = 'slideOutRight 0.5s ease';
-            setTimeout(() => notification.remove(), 500);
-        }
-    }, 5000);
-}
-</script>
-@endpush
-@endsection
+use App\Models\Product;
+use App\Models\MenuItem;
+use Illuminate\Database\Seeder;
+
+class ProductSeeder extends Seeder
+{
+    /**
+     * Run the database seeder.
+     */
+    public function run(): void
+    {
+        $categories = MenuItem::all();
+        
+        $products = [
+            [
+                'name' => 'Artisan Sourdough Loaf',
+                'description' => 'Traditional sourdough bread with a perfect crust and tangy flavor. Made with our signature starter that has been cultivated for over 5 years.',
+                'price' => 450.00,
+                'category_id' => $categories->where('category', 'Fresh Bread')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Classic French Croissant',
+                'description' => 'Buttery, flaky croissant made with premium French butter. Laminated to perfection with 81 layers for the ultimate pastry experience.',
+                'price' => 280.00,
+                'category_id' => $categories->where('category', 'Pastries')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Chocolate Pain au Chocolat',
+                'description' => 'Flaky pastry filled with rich Belgian dark chocolate. A decadent morning treat that pairs perfectly with our espresso.',
+                'price' => 350.00,
+                'category_id' => $categories->where('category', 'Pastries')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Red Velvet Cake Slice',
+                'description' => 'Moist red velvet cake with cream cheese frosting. Made with natural cocoa and a hint of vanilla for the perfect balance.',
+                'price' => 580.00,
+                'category_id' => $categories->where('category', 'Cakes & Desserts')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Strawberry Danish',
+                'description' => 'Delicate Danish pastry topped with fresh strawberries and vanilla custard. A seasonal favorite that celebrates local fruit.',
+                'price' => 420.00,
+                'category_id' => $categories->where('category', 'Pastries')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Artisan Coffee Blend',
+                'description' => 'Our signature coffee blend featuring beans from three continents. Medium roast with notes of chocolate, caramel, and citrus.',
+                'price' => 380.00,
+                'category_id' => $categories->where('category', 'Beverages')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Ceylon Tea Selection',
+                'description' => 'Premium Ceylon black tea sourced from the highlands of Sri Lanka. Rich, aromatic, and perfect for any time of day.',
+                'price' => 320.00,
+                'category_id' => $categories->where('category', 'Beverages')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1597318374671-96ee162414ca?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Blueberry Muffin',
+                'description' => 'Fluffy muffin bursting with fresh blueberries. Made with organic flour and free-range eggs for the perfect breakfast treat.',
+                'price' => 320.00,
+                'category_id' => $categories->where('category', 'Breakfast Items')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1607958996333-41aef7caefaa?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Cinnamon Roll',
+                'description' => 'Soft, sweet roll swirled with Ceylon cinnamon and topped with cream cheese glaze. A warm, comforting breakfast favorite.',
+                'price' => 380.00,
+                'category_id' => $categories->where('category', 'Breakfast Items')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Lemon Tart',
+                'description' => 'Tangy lemon curd in a crisp pastry shell topped with torched meringue. A refreshing dessert that balances sweet and tart perfectly.',
+                'price' => 450.00,
+                'category_id' => $categories->where('category', 'Cakes & Desserts')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Chocolate Eclair',
+                'description' => 'Light choux pastry filled with vanilla cream and topped with rich chocolate glaze. A classic French pastry executed to perfection.',
+                'price' => 420.00,
+                'category_id' => $categories->where('category', 'Cakes & Desserts')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+            [
+                'name' => 'Whole Wheat Sandwich Bread',
+                'description' => 'Nutritious whole wheat bread perfect for sandwiches. Made with organic whole wheat flour and a touch of honey.',
+                'price' => 320.00,
+                'category_id' => $categories->where('category', 'Fresh Bread')->first()?->id,
+                'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop',
+                'is_active' => true,
+            ],
+        ];

+        foreach ($products as $productData) {
+            Product::create($productData);
+        }
+        
+        $this->command->info('Sample bakery products created successfully!');
+    }
+}
+