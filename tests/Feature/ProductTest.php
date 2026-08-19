<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function createCategory(): Category
    {
        return Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
        ]);
    }

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);
    }

    public function test_products_can_be_listed(): void
    {
        $category = $this->createCategory();

        Product::create([
            'category_id' => $category->id,
            'name' => 'Test Phone',
            'description' => 'Test description',
            'price' => 10000,
            'stock' => 10,
        ]);

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'Test Phone');
    }

    public function test_admin_can_create_product(): void
    {
        $category = $this->createCategory();
        $admin = $this->createAdmin();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'New Phone',
            'description' => 'New phone description',
            'price' => 15000,
            'stock' => 20,
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonPath('data.name', 'New Phone')
            ->assertJsonPath('data.stock', 20);

        $this->assertDatabaseHas('products', [
            'name' => 'New Phone',
            'stock' => 20,
        ]);
    }

    public function test_admin_can_update_product(): void
    {
        $category = $this->createCategory();
        $admin = $this->createAdmin();

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Old Phone',
            'description' => 'Old description',
            'price' => 10000,
            'stock' => 10,
        ]);

        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Phone',
            'price' => 12000,
            'stock' => 15,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Phone')
            ->assertJsonPath('data.stock', 15);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Phone',
            'stock' => 15,
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $category = $this->createCategory();
        $admin = $this->createAdmin();

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Delete Phone',
            'description' => 'Delete description',
            'price' => 10000,
            'stock' => 10,
        ]);

        Sanctum::actingAs($admin);

        $this->deleteJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Product deleted successfully');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_product_validation_rejects_invalid_data(): void
    {
        $category = $this->createCategory();
        $admin = $this->createAdmin();

        Sanctum::actingAs($admin);

        $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => '',
            'price' => -1,
            'stock' => -1,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'price',
                'stock',
            ]);
    }

    public function test_normal_user_cannot_create_product(): void
    {
        $category = $this->createCategory();

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        Sanctum::actingAs($user);

        $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Forbidden Product',
            'description' => 'Description',
            'price' => 10000,
            'stock' => 10,
        ])->assertForbidden();
    }
}
