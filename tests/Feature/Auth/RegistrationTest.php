<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'intern',
            'is_active' => true,
        ]);

        $response->assertRedirect(
            route('dashboard', absolute: false)
        );
    }
}