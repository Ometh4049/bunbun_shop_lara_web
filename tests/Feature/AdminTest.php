<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_admin' => true,
        ]);
        
        // Create regular user
        $this->user = User::factory()->create([
            'role' => 'customer',
            'is_admin' => false,
        ]);
    }

    public function test_users_table_has_is_admin_column()
    {
        $this->assertTrue(
            \Schema::hasColumn('users', 'is_admin'),
            'Users table should have is_admin column'
        );
    }

    public function test_admin_seeder_creates_admin_user()
    {
        $this->artisan('db:seed', ['--class' => 'AdminSeeder']);
        
        $this->assertDatabaseHas('users', [
            'email' => 'admin@sweetdelights.lk',
            'is_admin' => true,
        ]);
    }

    public function test_admin_can_access_admin_routes()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_admin_routes()
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_routes()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_create_product()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'Test Croissant',
            'description' => 'Delicious test croissant',
            'price' => 250.00,
            'image' => $file,
            'is_active' => true,
        ]);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Croissant',
            'price' => 250.00,
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists('products/' . $file->hashName());
    }

    public function test_admin_can_update_product()
    {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'price' => 100.00,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/products/{$product->id}", [
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'price' => 150.00,
            'is_active' => true,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => 150.00,
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_non_admin_cannot_manage_products()
    {
        $response = $this->actingAs($this->user)->post('/admin/products', [
            'name' => 'Test Product',
            'price' => 100.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_product_validation_works()
    {
        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => '', // Required field missing
            'price' => -10, // Invalid price
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price']);
    }

    public function test_image_upload_validation()
    {
        Storage::fake('public');

        // Test invalid file type
        $file = UploadedFile::fake()->create('document.pdf', 1000);

        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'Test Product',
            'price' => 100.00,
            'image' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }
}