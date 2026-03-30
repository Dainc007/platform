<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdmin()
    {
        return User::factory()->create([
            'email' => 'danielheinze96@gmail.com',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_access_user_management()
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Users')
            ->has('users.data')
        );
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_toggle_user_status()
    {
        $admin = $this->getAdmin();
        $user = User::factory()->create(['is_active' => false]);

        // Activate
        $response = $this->actingAs($admin)->post(route('admin.users.toggle', $user));
        $response->assertRedirect();
        $this->assertTrue($user->fresh()->is_active);

        // Deactivate
        $response = $this->actingAs($admin)->post(route('admin.users.toggle', $user));
        $response->assertRedirect();
        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_admin_cannot_deactivate_themselves()
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->post(route('admin.users.toggle', $admin));

        $this->assertTrue($admin->fresh()->is_active);
        $response->assertSessionHas('message', 'You cannot deactivate your own account.');
    }

    public function test_inactive_user_is_redirected_to_inactive_page()
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('inactive'));

        $response = $this->actingAs($user)->get(route('inactive'));
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('Auth/Inactive'));
    }

    public function test_active_user_can_access_dashboard()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }

    public function test_pre_existing_users_work_with_default_active_status()
    {
        // Simulate pre-existing user by creating one with default factory (assuming migration set default to true)
        // Actually, my migration for users table didn't set is_active default.
        // Let's check the migration file again.
        $user = User::factory()->create();

        // If the migration didn't set a default, it might be null if nullable, or fail if not.
        // In my previous task I added $table->boolean('is_active')->default(true);

        $this->assertTrue($user->is_active);
    }
}
