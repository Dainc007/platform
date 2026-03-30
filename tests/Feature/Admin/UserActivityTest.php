<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_activity()
    {
        $admin = User::factory()->create(['email' => 'kontakt@partio.pl', 'is_active' => true]);
        $user = User::factory()->create();

        // Seed some sessions
        DB::table('sessions')->insert([
            'id' => 'sess1',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
            'payload' => 'payload',
            'last_activity' => time(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.activity', $user));

        $response->assertStatus(200);
        $response->assertJsonFragment(['ip_address' => '127.0.0.1']);
        $response->assertJsonFragment(['user_agent' => 'Mozilla/5.0']);
        $response->assertJsonFragment(['location' => 'Localhost']);
    }
}
