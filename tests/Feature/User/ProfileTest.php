<?php

namespace Tests\Feature\User;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_profile_and_returns_there_after_login(): void
    {
        $user = $this->user();

        $this->get(route('profile.show'))
            ->assertRedirect(route('login'));

        $this->post(route('login.submit'), [
            'email' => $user->email,
            'password' => 'Password123',
        ])->assertRedirect(route('profile.show'));
    }

    public function test_profile_shows_only_the_current_users_stats_and_review_history(): void
    {
        $user = $this->user('Gung Diah');
        $otherUser = $this->user('Pengguna Lain');
        $destination = Destination::create([
            'name' => 'Monumen Bajra Sandhi',
            'description' => 'Monumen sejarah.',
            'image' => null,
        ]);
        $otherDestination = Destination::create([
            'name' => 'Museum Bali',
            'description' => 'Museum budaya.',
            'image' => null,
        ]);
        $user->trips()->create([
            'trip_name' => 'Trip Saya',
            'start_date' => '2026-12-01',
            'end_date' => '2026-12-02',
        ]);
        $user->reviews()->create([
            'destination_id' => $destination->id,
            'rating' => 5,
            'review' => 'Pengalaman yang berkesan.',
        ]);
        $otherUser->trips()->create([
            'trip_name' => 'Trip Pribadi Lain',
            'start_date' => '2026-12-01',
            'end_date' => '2026-12-02',
        ]);
        $otherUser->reviews()->create([
            'destination_id' => $otherDestination->id,
            'rating' => 1,
            'review' => 'Ulasan milik pengguna lain.',
        ]);

        $response = $this->actingAs($user)
            ->get(route('profile.show'))
            ->assertOk();

        $response
            ->assertSee('Gung Diah')
            ->assertSee($user->email)
            ->assertSee('Monumen Bajra Sandhi')
            ->assertSee('Pengalaman yang berkesan.')
            ->assertDontSee('Pengguna Lain')
            ->assertDontSee('Trip Pribadi Lain')
            ->assertDontSee('Ulasan milik pengguna lain.')
            ->assertDontSee('<strong>2</strong>', false);
    }

    public function test_user_can_update_name_email_and_password_without_exposing_current_password(): void
    {
        $user = $this->user('Nama Lama');

        $this->actingAs($user)
            ->get(route('profile.show'))
            ->assertOk()
            ->assertDontSee('Password123');

        $this->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'nama.baru@example.test',
        ])->assertRedirect(route('profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'nama.baru@example.test',
        ]);
        $this->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee('Menu akun Nama Baru');

        $this->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'nama.baru@example.test',
            'current_password' => 'Password123',
            'new_password' => 'UpdatedPass456',
            'new_password_confirmation' => 'UpdatedPass456',
        ])->assertRedirect(route('profile.show'));

        $this->assertTrue(Hash::check('UpdatedPass456', $user->fresh()->password));
    }

    public function test_profile_rejects_duplicate_email_and_invalid_password_change(): void
    {
        $user = $this->user('Pemilik');
        $another = $this->user('Akun Lain');

        $this->actingAs($user)
            ->from(route('profile.show'))
            ->put(route('profile.update'), [
                'name' => 'Pemilik',
                'email' => $another->email,
                'current_password' => 'wrong-password',
                'new_password' => 'short',
                'new_password_confirmation' => 'different',
            ])
            ->assertRedirect(route('profile.show'))
            ->assertSessionHasErrors(['email', 'current_password', 'new_password']);
    }

    public function test_profile_is_not_available_to_admins_or_other_account_urls(): void
    {
        $admin = $this->user('Admin', 'admin');
        $user = $this->user('Pengguna');

        $this->actingAs($admin)
            ->get(route('profile.show'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/user/profile/' . $admin->id)
            ->assertNotFound();

        $this->put('/user/profile/' . $admin->id, [
            'name' => 'Nama diubah',
            'email' => 'changed@example.test',
        ])->assertNotFound();

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'name' => 'Admin']);
    }

    public function test_navbar_changes_from_guest_login_link_to_current_users_profile_menu(): void
    {
        $this->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee(route('login'), false)
            ->assertDontSee('Menu akun', false);

        $user = $this->user('Gung Diah');
        $this->actingAs($user)
            ->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee('Menu akun Gung Diah')
            ->assertSee(route('profile.show'), false)
            ->assertSee('GD');
    }

    public function test_trip_planner_and_my_trip_require_login_but_home_and_explore_are_public(): void
    {
        $this->get(route('user.dashboard'))->assertOk();
        $this->get(route('explore.index'))->assertOk();
        $this->get(route('trips.create'))->assertRedirect(route('login'));
        $this->get(route('my-trips.index'))->assertRedirect(route('login'));

        $user = $this->user();
        $this->actingAs($user)
            ->get(route('trips.create'))
            ->assertOk()
            ->assertSee('Rencanakan')
            ->assertSee('Tanggal Mulai');
        $this->actingAs($user)
            ->get(route('my-trips.index'))
            ->assertOk()
            ->assertSee('Belum ada trip tersimpan');
    }

    public function test_logout_clears_the_authenticated_session(): void
    {
        $this->actingAs($this->user())
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->get(route('profile.show'))
            ->assertRedirect(route('login'));
    }

    private function user(string $name = 'Wisatawan', string $role = 'user'): User
    {
        return User::forceCreate([
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password123',
            'role' => $role,
        ]);
    }
}
