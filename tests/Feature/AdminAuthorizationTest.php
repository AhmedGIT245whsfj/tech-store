<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_users_endpoint(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        Sanctum::actingAs($admin);

        $this->getJson('/api/admin/users')
            ->assertOk();
    }

    public function test_normal_user_cannot_access_admin_users_endpoint(): void
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/admin/users')
            ->assertForbidden()
            ->assertJsonPath('message', 'Forbidden');
    }

    public function test_guest_cannot_access_admin_users_endpoint(): void
    {
        $this->getJson('/api/admin/users')
            ->assertUnauthorized();
    }
}
