<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guest is redirected to login when visiting dashboard.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated HR user can access dashboard.
     */
    public function test_hr_user_can_access_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'HR']);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }
}
