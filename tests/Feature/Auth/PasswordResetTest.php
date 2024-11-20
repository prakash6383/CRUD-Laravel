<?php

namespace Tests\Feature\Auth;

use App\Models\Trainee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/reset');

        $response->assertStatus(200);
    }

    public function test_update_the_password(): void
    {
        $user = Trainee::factory()->create();

        $response = $this->post('/password/reset', [
            'email' => $user->email,
            'password' => 'Prakash@123',
        ]);

        $response->assertRedirect('/');
    }
}
