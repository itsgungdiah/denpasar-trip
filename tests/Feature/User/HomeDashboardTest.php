<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_the_user_homepage(): void
    {
        $this->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee('Rencanakan');
    }

    public function test_admin_can_open_the_public_homepage(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('user.dashboard'))
            ->assertOk();
    }

    public function test_user_homepage_renders_sections_and_only_database_destinations(): void
    {
        $user = User::forceCreate([
            'name' => 'Wisatawan',
            'email' => 'user@example.test',
            'password' => 'password',
            'role' => 'user',
        ]);
        $culture = Category::forceCreate(['name' => 'Culture']);
        $art = Category::forceCreate(['name' => 'Art']);
        $destination = Destination::create([
            'name' => 'Museum Bali',
            'description' => 'Museum sejarah dan budaya di Denpasar.',
            'opening_hours' => ['schedules' => [], 'notes' => ''],
            'entrance_fee' => ['type' => 'free'],
            'average_spending' => ['type' => null],
        ]);
        $destination->categories()->sync([$culture->id, $art->id]);

        $this->actingAs($user)
            ->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee('Rencanakan<br>Perjalananmu ke', false)
            ->assertSee('Jelajahi Denpasar Dengan Caramu')
            ->assertSee('Jelajahi Berdasarkan Minat')
            ->assertSee('Populer di Denpasar')
            ->assertSee('Siap Merencanakan')
            ->assertSee('Museum Bali')
            ->assertSee('Museum sejarah dan budaya di Denpasar.')
            ->assertSee('images/about.png')
            ->assertSee('images/landing.png')
            ->assertSee('images/cta-home.png')
            ->assertSee('images/museum.jpg')
            ->assertSee('Culture')
            ->assertSee('Art')
            ->assertSee('Halaman detail destinasi belum tersedia')
            ->assertSee(route('trips.create'), false)
            ->assertSee(route('my-trips.index'), false);
    }

    public function test_user_homepage_shows_an_empty_state_without_fabricated_popular_destinations(): void
    {
        $user = User::forceCreate([
            'name' => 'Wisatawan',
            'email' => 'empty@example.test',
            'password' => 'password',
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('user.dashboard'))
            ->assertOk()
            ->assertSee('Belum ada destinasi populer untuk ditampilkan.')
            ->assertDontSee('Monumen Bajra Sandhi')
            ->assertDontSee('Pantai Sanur')
            ->assertDontSee('Pasar Badung')
            ->assertDontSee('Museum Bali');
    }
}
