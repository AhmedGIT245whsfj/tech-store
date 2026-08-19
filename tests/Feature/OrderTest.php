<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $email = 'user@example.com'): User
    {
        return User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password123',
            'role' => 'user',
        ]);
    }

    private function createCategory(): Category
    {
        return Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
        ]);
    }

    private function createProduct(
        Category $category,
        string $name,
        float $price,
        int $stock
    ): Product {
        return Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'description' => 'Test product',
            'price' => $price,
            'stock' => $stock,
        ]);
    }

    public function test_user_can_create_order(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();
        $product = $this->createProduct($category, 'Test Phone', 10000, 10);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonPath('data.total_price', '20000.00')
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.items.0.quantity', 2);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 20000,
            'status' => 'pending',
        ]);
    }

    public function test_order_calculates_total_for_multiple_products(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $first = $this->createProduct($category, 'Phone One', 10000, 10);
        $second = $this->createProduct($category, 'Phone Two', 5000, 10);

        Sanctum::actingAs($user);

        $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $first->id,
                    'quantity' => 2,
                ],
                [
                    'product_id' => $second->id,
                    'quantity' => 3,
                ],
            ],
        ])
            ->assertSuccessful()
            ->assertJsonPath('data.total_price', '35000.00');
    }

    public function test_order_reduces_product_stock(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();
        $product = $this->createProduct($category, 'Stock Phone', 10000, 10);

        Sanctum::actingAs($user);

        $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 3,
                ],
            ],
        ])->assertSuccessful();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);
    }

    public function test_order_fails_when_stock_is_insufficient(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();
        $product = $this->createProduct($category, 'Limited Phone', 10000, 2);

        Sanctum::actingAs($user);

        $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['items']);

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 2,
        ]);
    }

    public function test_user_cannot_view_another_users_order(): void
    {
        $firstUser = $this->createUser('first@example.com');
        $secondUser = $this->createUser('second@example.com');

        $order = Order::create([
            'user_id' => $firstUser->id,
            'total_price' => 10000,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($secondUser);

        $this->getJson("/api/orders/{$order->id}")
            ->assertForbidden()
            ->assertJsonPath('message', 'Forbidden');
    }

    public function test_guest_cannot_create_order(): void
    {
        $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => 1,
                    'quantity' => 1,
                ],
            ],
        ])->assertUnauthorized();
    }
}
