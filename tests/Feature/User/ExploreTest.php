<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExploreTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_explore(): void
    {
        $this->get(route('explore.index'))
            ->assertOk()
            ->assertSee('Jelajahi Denpasar');
    }

    public function test_admin_can_open_public_explore(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin-explore@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('explore.index'))
            ->assertOk();
    }

    public function test_user_can_search_and_filter_by_multiple_categories(): void
    {
        $user = $this->user();
        $culture = Category::forceCreate(['name' => 'Culture']);
        $art = Category::forceCreate(['name' => 'Art']);
        $nature = Category::forceCreate(['name' => 'Nature']);

        $bajra = $this->destination('Bajra Sandhi', 'Culture destination.');
        $bajra->categories()->sync([$culture->id]);
        $gallery = $this->destination('Denpasar Art Gallery', 'Art destination.');
        $gallery->categories()->sync([$art->id]);
        $pantai = $this->destination('Pantai Sanur', 'Nature destination.');
        $pantai->categories()->sync([$nature->id]);

        $this->actingAs($user)
            ->get(route('explore.index', [
                'search' => 'Denpasar',
                'categories' => ['Culture', 'Art'],
            ]))
            ->assertOk()
            ->assertSee('Denpasar Art Gallery')
            ->assertDontSee('Bajra Sandhi')
            ->assertDontSee('Pantai Sanur');
    }

    public function test_explore_paginates_sixteen_results_and_keeps_filters_in_links(): void
    {
        $user = $this->user();
        $nature = Category::forceCreate(['name' => 'Nature']);

        for ($index = 1; $index <= 17; $index++) {
            $destination = $this->destination(sprintf('Sanur Beach %02d', $index), 'Nature destination.');
            $destination->categories()->sync([$nature->id]);
        }

        $this->actingAs($user)
            ->get(route('explore.index', ['search' => 'Sanur', 'categories' => ['Nature']]))
            ->assertOk()
            ->assertSee('Menampilkan 16 dari 17 destinasi')
            ->assertSee('search=Sanur', false)
            ->assertSee('categories%5B0%5D=Nature', false);

        $this->actingAs($user)
            ->get(route('explore.index', ['search' => 'Sanur', 'categories' => ['Nature'], 'page' => 2]))
            ->assertOk()
            ->assertSee('Menampilkan 1 dari 17 destinasi')
            ->assertSee('Sanur Beach 17');
    }

    public function test_empty_state_appears_when_no_destinations_match(): void
    {
        $this->actingAs($this->user())
            ->get(route('explore.index', ['search' => 'tidak-ada']))
            ->assertOk()
            ->assertSee('Destinasi tidak ditemukan')
            ->assertSee('images/explore.png')
            ->assertSee('images/cta-explore.png');
    }

    public function test_spending_range_and_sort_filters_use_saved_destination_values(): void
    {
        $user = $this->user();
        $expensive = $this->destination('Expensive Place', 'Higher spending.', ['type' => 'fixed', 'amount' => 250000]);
        $affordable = $this->destination('Affordable Place', 'Lower spending.', ['type' => 'fixed', 'amount' => 75000]);
        $unknown = $this->destination('Unknown Cost Place', 'No spending data.', ['type' => null]);

        $this->actingAs($user)
            ->get(route('explore.index', [
                'min_spending' => 50000,
                'max_spending' => 100000,
                'sort' => 'spending_asc',
            ]))
            ->assertOk()
            ->assertSeeInOrder(['Affordable Place'])
            ->assertDontSee('Expensive Place')
            ->assertDontSee('Unknown Cost Place');
    }

    private function user(): User
    {
        return User::forceCreate([
            'name' => 'Wisatawan',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'role' => 'user',
        ]);
    }

    private function destination(string $name, string $description, array $averageSpending = ['type' => null]): Destination
    {
        return Destination::create([
            'name' => $name,
            'description' => $description,
            'opening_hours' => ['schedules' => [], 'notes' => ''],
            'entrance_fee' => ['type' => 'free'],
            'average_spending' => $averageSpending,
        ]);
    }
}
