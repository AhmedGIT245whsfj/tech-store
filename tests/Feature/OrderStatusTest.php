<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 10000,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $this->patchJson("/api/admin/orders/{$order->id}/status", [
            'status' => 'completed',
        ])
            ->assertOk()
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }

    public function test_invalid_order_status_is_rejected(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 10000,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $this->patchJson("/api/admin/orders/{$order->id}/status", [
            'status' => 'shipped',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);
    }

    public function test_normal_user_cannot_update_order_status(): void
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 10000,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($user);

        $this->patchJson("/api/admin/orders/{$order->id}/status", [
            'status' => 'completed',
        ])->assertForbidden();
    }
}
