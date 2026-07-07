<?php

namespace Tests\Feature\Auth;

use App\Mail\VerifyEmailMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'birth_year' => 1990,
            'agree_terms' => '1',
            'agree_privacy' => '1',
        ]);

        // Registered but must verify e-mail before entering the app.
        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice'));
        Mail::assertQueued(VerifyEmailMail::class);
    }

    public function test_underage_users_cannot_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Kid',
            'email' => 'kid@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'birth_year' => (int) now()->year - 15,
            'agree_terms' => '1',
            'agree_privacy' => '1',
        ]);

        $response->assertSessionHasErrors('birth_year');
        $this->assertGuest();
    }

    public function test_unverified_users_cannot_enter_the_app(): void
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'birth_year' => 1990,
            'agree_terms' => '1',
            'agree_privacy' => '1',
        ]);

        // Any verified-only page must bounce to the verification notice.
        $this->get('/profile')->assertRedirect(route('verification.notice'));
    }
}
