<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestinationDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_fetch_destination_detail(): void
    {
        $destination = $this->destination('Pantai Sanur');

        $this->get(route('user.destinations.detail', $destination))
            ->assertOk()
            ->assertSee($destination->name);
    }

    public function test_admin_can_fetch_public_destination_detail(): void
    {
        $admin = User::forceCreate([
            'name' => 'Admin',
            'email' => 'detail-admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $destination = $this->destination('Museum Bali');

        $this->actingAs($admin)
            ->get(route('user.destinations.detail', $destination))
            ->assertOk()
            ->assertSee($destination->name);
    }

    public function test_user_receives_only_selected_destination_and_database_details(): void
    {
        $user = $this->user();
        $nature = Category::forceCreate(['name' => 'Nature']);
        $destination = $this->destination('Pantai Sanur', [
            'schedules' => [
                ['days' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], 'hours' => '08.00 - 17.00'],
                ['days' => ['Sabtu'], 'hours' => '09.00 - 17.00'],
            ],
            'notes' => 'Jadwal dapat berubah pada hari libur.',
        ], ['type' => 'range', 'min' => 5000, 'max' => 10000], ['type' => 'range', 'min' => 100000, 'max' => 200000], 'https://maps.google.com/?q=pantai+sanur');
        $destination->categories()->sync([$nature->id]);
        $this->destination('Museum Bali', ['schedules' => [], 'notes' => ''], ['type' => 'free'], ['type' => null]);

        $this->actingAs($user)
            ->get(route('user.destinations.detail', $destination))
            ->assertOk()
            ->assertSee('Pantai Sanur')
            ->assertSee('Nature')
            ->assertSee('08.00 - 17.00')
            ->assertSee('09.00 - 17.00')
            ->assertSee('Jadwal dapat berubah pada hari libur.')
            ->assertSee('Rp5.000 – Rp10.000')
            ->assertSee('Rp100.000 – Rp200.000')
            ->assertSee('https://maps.google.com/?q=pantai+sanur')
            ->assertDontSee('Museum Bali')
            ->assertSee('Ulasan Pengunjung')
            ->assertSee('Belum ada ulasan untuk destinasi ini.');
    }

    public function test_empty_detail_fields_use_neutral_placeholders_without_fabricated_values(): void
    {
        $destination = $this->destination('Destinasi Tanpa Informasi');

        $this->actingAs($this->user())
            ->get(route('user.destinations.detail', $destination))
            ->assertOk()
            ->assertSee('Gambar belum tersedia')
            ->assertSee('Informasi jam operasional belum tersedia.')
            ->assertSee('Informasi tiket belum tersedia.')
            ->assertSee('Informasi pengeluaran belum tersedia.')
            ->assertSee('Tautan Google Maps belum tersedia')
            ->assertSee('Belum ada ulasan untuk destinasi ini.')
            ->assertDontSee('08.00 - 17.00')
            ->assertDontSee('Rp');
    }

    public function test_detail_modal_shows_only_recent_reviews_for_the_selected_destination(): void
    {
        $destination = $this->destination('Monumen Bajra Sandhi');
        $otherDestination = $this->destination('Museum Bali');
        $oldReviewer = $this->user('Reviewer Lama');
        $recentReviewer = $this->user('Reviewer Terbaru');
        $otherReviewer = $this->user('Reviewer Tujuan Lain');

        Review::create([
            'user_id' => $oldReviewer->id,
            'destination_id' => $destination->id,
            'rating' => 3,
            'review' => 'Ulasan yang lebih lama.',
            'created_at' => now()->subDays(5),
        ]);
        Review::create([
            'user_id' => $recentReviewer->id,
            'destination_id' => $destination->id,
            'rating' => 5,
            'review' => 'Ulasan terbaru untuk Bajra Sandhi.',
            'created_at' => now(),
        ]);
        Review::create([
            'user_id' => $otherReviewer->id,
            'destination_id' => $otherDestination->id,
            'rating' => 1,
            'review' => 'Ulasan yang hanya milik Museum Bali.',
        ]);

        $this->actingAs($this->user())
            ->get(route('user.destinations.detail', $destination))
            ->assertOk()
            ->assertSee('2 ulasan')
            ->assertSee('Reviewer Terbaru')
            ->assertSee('Ulasan terbaru untuk Bajra Sandhi.')
            ->assertSee('Reviewer Lama')
            ->assertSee('aria-label="5 dari 5 bintang"', false)
            ->assertDontSee('Reviewer Tujuan Lain')
            ->assertDontSee('Ulasan yang hanya milik Museum Bali.');
    }

    public function test_view_all_reviews_endpoint_shows_only_the_destination_reviews_with_pagination(): void
    {
        $destination = $this->destination('Monumen Bajra Sandhi');
        $otherDestination = $this->destination('Museum Bali');

        for ($index = 1; $index <= 11; $index++) {
            $reviewer = $this->user('Pengulas ' . $index);
            Review::create([
                'user_id' => $reviewer->id,
                'destination_id' => $destination->id,
                'rating' => 4,
                'review' => sprintf('Ulasan destinasi nomor %02d', $index),
            ]);
        }

        $otherReviewer = $this->user('Pengulas destinasi lain');
        Review::create([
            'user_id' => $otherReviewer->id,
            'destination_id' => $otherDestination->id,
            'rating' => 5,
            'review' => 'Ulasan yang tidak boleh ikut.',
        ]);

        $this->actingAs($this->user())
            ->get(route('user.destinations.reviews', $destination))
            ->assertOk()
            ->assertSee('Pengulas 2')
            ->assertSee('Pengulas 10')
            ->assertSee('Pengulas 11')
            ->assertDontSee('Ulasan destinasi nomor 01')
            ->assertDontSee('Pengulas destinasi lain')
            ->assertDontSee('Ulasan yang tidak boleh ikut.')
            ->assertSee('page=2', false);

        $this->get(route('user.destinations.reviews', ['destination' => $destination->id, 'page' => 2]))
            ->assertOk()
            ->assertSee('Pengulas 1')
            ->assertDontSee('Ulasan yang tidak boleh ikut.');
    }

    public function test_user_can_submit_a_review_for_the_selected_destination(): void
    {
        $user = $this->user('Pengunjung Uji');
        $destination = $this->destination('Museum Bali');

        $response = $this->actingAs($user)
            ->postJson(route('user.destinations.reviews.store', $destination), [
                'rating' => 5,
                'review' => 'Pengalaman yang sangat berkesan.',
            ]);

        $response->assertOk()->assertJsonStructure(['html']);
        $this->assertStringContainsString('Pengalaman yang sangat berkesan.', $response->json('html'));
        $this->assertStringContainsString('Ulasanmu untuk destinasi ini sudah dikirim.', $response->json('html'));

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'destination_id' => $destination->id,
            'rating' => 5,
            'review' => 'Pengalaman yang sangat berkesan.',
        ]);
    }

    public function test_review_submission_validates_rating_and_comment(): void
    {
        $destination = $this->destination('Pantai Sanur');

        $this->actingAs($this->user())
            ->postJson(route('user.destinations.reviews.store', $destination), [
                'rating' => 6,
                'review' => '',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['rating', 'review']);
    }

    public function test_user_can_submit_only_one_review_per_destination(): void
    {
        $user = $this->user();
        $destination = $this->destination('Monumen Bajra Sandhi');
        Review::create([
            'user_id' => $user->id,
            'destination_id' => $destination->id,
            'rating' => 4,
            'review' => 'Ulasan pertama.',
        ]);

        $this->actingAs($user)
            ->postJson(route('user.destinations.reviews.store', $destination), [
                'rating' => 2,
                'review' => 'Ulasan kedua.',
            ])
            ->assertStatus(409)
            ->assertJsonPath('message', 'Kamu sudah mengirim ulasan untuk destinasi ini.');

        $this->assertDatabaseCount('reviews', 1);
    }

    public function test_explore_detail_button_targets_selected_destination(): void
    {
        $destination = $this->destination('Monumen Bajra Sandhi');

        $this->actingAs($this->user())
            ->get(route('explore.index'))
            ->assertOk()
            ->assertSee('data-destination-detail', false)
            ->assertSee(route('user.destinations.detail', $destination), false);
    }

    private function user(string $name = 'Wisatawan'): User
    {
        return User::forceCreate([
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'role' => 'user',
        ]);
    }

    private function destination(
        string $name,
        array $openingHours = [],
        array $entranceFee = [],
        array $averageSpending = [],
        ?string $mapsUrl = null,
    ): Destination {
        return Destination::create([
            'name' => $name,
            'description' => $name . ' memiliki deskripsi yang tersimpan di database.',
            'opening_hours' => $openingHours,
            'entrance_fee' => $entranceFee,
            'average_spending' => $averageSpending,
            'google_maps_url' => $mapsUrl,
        ]);
    }
}
