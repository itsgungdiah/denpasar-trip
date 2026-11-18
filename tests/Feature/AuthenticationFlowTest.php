<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;

class AuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_signup_forms_render_authentication_controls(): void
    {
        $this->withoutVite();

        $this->get('/login')
            ->assertOk()
            ->assertSee('data-auth-form="login"', false)
            ->assertSee('Google')
            ->assertSee('backdrop-blur-2xl', false)
            ->assertDontSee('data-submit-arrow', false)
            ->assertDontSee('Apple');

        $this->get('/register')
            ->assertOk()
            ->assertSee('data-auth-form="register"', false)
            ->assertSee('name="password_confirmation"', false)
            ->assertSee('Google')
            ->assertSee('backdrop-blur-2xl', false)
            ->assertDontSee('data-submit-arrow', false)
            ->assertDontSee('Apple');
    }

    public function test_signup_rejects_invalid_fields_on_the_server(): void
    {
        $this->from('/register')->post('/register', [
            'name' => ' ',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertRedirect('/register')
            ->assertSessionHasErrors(['name', 'email', 'password', 'password_confirmation', 'terms']);
    }

    public function test_signup_rejects_existing_email_and_requires_a_separate_login(): void
    {
        $existingUser = User::factory()->create(['email' => 'registered@example.test']);

        $this->from('/register')->post('/register', [
            'name' => 'New Traveler',
            'email' => ' REGISTERED@example.test ',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
            'terms' => '1',
        ])->assertRedirect('/register')->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();

        $this->post('/register', [
            'name' => 'New Traveler',
            'email' => 'new@example.test',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
            'terms' => '1',
        ])->assertRedirect(route('login'))->assertSessionHas('success');

        $this->assertGuest();
        $this->post('/login', ['email' => 'new@example.test', 'password' => 'StrongPass123'])
            ->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'new@example.test')->first());
    }

    public function test_password_reset_link_and_password_change_work(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'traveler@example.test']);

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status');

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token): bool {
            $token = $notification->token;

            return true;
        });
        $this->assertNotNull($token);

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Buat password baru');

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'UpdatedPass456',
            'password_confirmation' => 'UpdatedPass456',
        ])->assertRedirect(route('login'))->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('UpdatedPass456', $user->password));
        $this->assertFalse(Hash::check('password', $user->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_login_rejects_missing_email_and_password(): void
    {
        $this->from('/login')->post('/login', [])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_oauth_redirect_reports_missing_provider_configuration(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
            'services.google.redirect' => null,
        ]);

        $this->get('/auth/google/redirect')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('oauth');
    }

    public function test_google_oauth_redirect_still_works(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect' => 'https://example.test/auth/google/callback',
        ]);

        $response = $this->get('/auth/google/redirect');

        $response->assertRedirect();
        $this->assertSame(
            'accounts.google.com',
            parse_url($response->headers->get('Location'), PHP_URL_HOST),
        );
    }

    public function test_apple_oauth_is_disabled_without_showing_an_error(): void
    {
        $this->get('/auth/apple/redirect')
            ->assertRedirect(route('login'))
            ->assertSessionHasNoErrors();

        $this->post('/auth/apple/callback', ['error' => 'access_denied'])
            ->assertRedirect(route('login'))
            ->assertSessionHasNoErrors();
    }

}
