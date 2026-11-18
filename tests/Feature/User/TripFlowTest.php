<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_trip_add_a_destination_and_view_it_in_my_trips(): void
    {
        $user = $this->user('Planner');
        $nature = Category::forceCreate(['name' => 'Nature']);
        $destination = Destination::create([
            'name' => 'Pantai Sanur',
            'description' => 'Pantai untuk menikmati suasana pesisir.',
            'image' => null,
        ]);
        $destination->categories()->sync([$nature->id]);

        $this->actingAs($user)
            ->get(route('trips.create'))
            ->assertOk()
            ->assertSee('LANGKAH 1 · DETAIL TRIP');

        $this->post(route('trips.store'), [
            'trip_name' => 'Akhir Pekan di Denpasar',
            'start_date' => '2027-03-10',
            'end_date' => '2027-03-12',
        ])->assertRedirect();

        $trip = Trip::query()->where('user_id', $user->id)->firstOrFail();
        $this->assertDatabaseHas('trips', ['id' => $trip->id, 'trip_name' => 'Akhir Pekan di Denpasar']);

        $this->get(route('trips.preferences.edit', $trip))
            ->assertOk()
            ->assertSee('Nature');

        $this->put(route('trips.preferences.update', $trip), ['categories' => [$nature->id]])
            ->assertRedirect(route('trips.discover', $trip));

        $this->get(route('trips.discover', $trip))
            ->assertOk()
            ->assertSee('Pantai Sanur');

        $this->post(route('trips.itineraries.store', $trip), [
            'destination_id' => $destination->id,
            'date' => '2027-03-11',
            'start_time' => '09:30',
            'duration' => 120,
            'sort_order' => 1,
            'note' => 'Berangkat pagi.',
        ])->assertRedirect(route('trips.discover', $trip));

        $this->assertDatabaseHas('itineraries', [
            'trip_id' => $trip->id,
            'destination_id' => $destination->id,
            'date' => '2027-03-11 00:00:00',
            'start_time' => '09:30',
            'duration' => 120,
            'sort_order' => 1,
        ]);

        $this->get(route('my-trips.index'))
            ->assertOk()
            ->assertSee('Akhir Pekan di Denpasar')
            ->assertSee('1 Tempat')
            ->assertSee('data-trip-detail-modal', false)
            ->assertSee('Day 1')
            ->assertSee('Pantai Sanur');

        $this->get(route('my-trips.show', $trip))
            ->assertOk()
            ->assertSee('Pantai Sanur')
            ->assertSee('Berangkat pagi.')
            ->assertSee('09:30');
    }

    public function test_my_trips_only_lists_trips_with_saved_itineraries_and_trip_access_is_owner_scoped(): void
    {
        $owner = $this->user('Pemilik');
        $otherUser = $this->user('Pengguna Lain');
        $destination = Destination::create(['name' => 'Museum Bali', 'description' => 'Museum.']);
        $draft = $owner->trips()->create([
            'trip_name' => 'Trip Draft',
            'start_date' => '2027-01-01',
            'end_date' => '2027-01-02',
        ]);
        $otherTrip = $otherUser->trips()->create([
            'trip_name' => 'Trip Pengguna Lain',
            'start_date' => '2027-02-01',
            'end_date' => '2027-02-02',
        ]);
        $otherTrip->itineraries()->create([
            'destination_id' => $destination->id,
            'date' => '2027-02-01',
            'start_time' => '10:00',
            'duration' => 60,
            'sort_order' => 1,
        ]);

        $this->actingAs($owner)
            ->get(route('my-trips.index'))
            ->assertOk()
            ->assertSee('Belum ada trip tersimpan')
            ->assertDontSee('Trip Draft')
            ->assertDontSee('Trip Pengguna Lain');

        $this->get(route('my-trips.show', $otherTrip))
            ->assertNotFound();
        $this->get(route('trips.discover', $otherTrip))
            ->assertNotFound();

        $this->assertDatabaseHas('trips', ['id' => $draft->id, 'user_id' => $owner->id]);
    }

    public function test_changing_trip_preferences_does_not_remove_saved_itinerary(): void
    {
        $user = $this->user();
        $nature = Category::forceCreate(['name' => 'Nature']);
        $culture = Category::forceCreate(['name' => 'Culture']);
        $destination = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $destination->categories()->sync([$nature->id]);
        $trip = $user->trips()->create([
            'trip_name' => 'Trip Manual',
            'start_date' => '2027-04-01',
            'end_date' => '2027-04-02',
        ]);
        $trip->preferences()->create(['category_id' => $nature->id]);
        $itinerary = $trip->itineraries()->create([
            'destination_id' => $destination->id,
            'date' => '2027-04-01',
            'start_time' => '08:00',
            'duration' => 90,
            'sort_order' => 1,
        ]);

        $this->actingAs($user)
            ->put(route('trips.preferences.update', $trip), ['categories' => [$culture->id]])
            ->assertRedirect(route('trips.discover', $trip));

        $this->assertDatabaseHas('itineraries', ['id' => $itinerary->id, 'trip_id' => $trip->id]);
        $this->assertDatabaseHas('trip_preferences', ['trip_id' => $trip->id, 'category_id' => $culture->id]);
    }

    public function test_itinerary_is_grouped_by_trip_day_and_can_be_reordered_and_removed(): void
    {
        $user = $this->user('Penyusun');
        $nature = Category::forceCreate(['name' => 'Nature']);
        $culture = Category::forceCreate(['name' => 'Culture']);
        $first = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $second = Destination::create(['name' => 'Taman Kota', 'description' => 'Taman.']);
        $first->categories()->sync([$nature->id]);
        $second->categories()->sync([$nature->id, $culture->id]);
        $trip = $user->trips()->create([
            'trip_name' => 'Trip Tiga Hari',
            'start_date' => '2027-06-01',
            'end_date' => '2027-06-03',
        ]);
        $trip->preferences()->create(['category_id' => $nature->id]);
        $one = $trip->itineraries()->create(['destination_id' => $first->id, 'date' => '2027-06-01', 'start_time' => '08:00', 'duration' => 60, 'sort_order' => 1]);
        $two = $trip->itineraries()->create(['destination_id' => $second->id, 'date' => '2027-06-01', 'start_time' => '10:00', 'duration' => 60, 'sort_order' => 2]);

        $this->actingAs($user)
            ->get(route('trips.discover', $trip))
            ->assertOk()
            ->assertSee('Day 1')
            ->assertSee('Day 3')
            ->assertSee('Pantai Sanur')
            ->assertSee('Nama A');

        $this->put(route('trips.itineraries.reorder', $trip), [
            'date' => '2027-06-01',
            'itinerary_ids' => [$two->id, $one->id],
        ])->assertRedirect();
        $this->assertDatabaseHas('itineraries', ['id' => $two->id, 'sort_order' => 1]);
        $this->assertDatabaseHas('itineraries', ['id' => $one->id, 'sort_order' => 2]);

        $this->delete(route('trips.itineraries.destroy', [$trip, $two->id]))->assertRedirect();
        $this->assertDatabaseMissing('itineraries', ['id' => $two->id]);
    }

    public function test_itinerary_can_be_added_and_updated_through_the_modal_json_flow(): void
    {
        $user = $this->user('Penyimpan');
        $nature = Category::forceCreate(['name' => 'Nature']);
        $destination = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $destination->categories()->sync([$nature->id]);
        $trip = $user->trips()->create([
            'trip_name' => 'Trip JSON',
            'start_date' => '2027-08-10',
            'end_date' => '2027-08-12',
        ]);

        $response = $this->actingAs($user)->postJson(route('trips.itineraries.store', $trip), [
            'destination_id' => $destination->id,
            'date' => '2027-08-10',
            'start_time' => '08:00',
            'duration' => 90,
            'sort_order' => 1,
            'note' => 'Datang pagi.',
        ]);

        $response->assertCreated()->assertJsonPath('message', 'Destinasi berhasil ditambahkan ke itinerary.');
        $itineraryId = $response->json('itinerary_id');
        $this->assertDatabaseHas('itineraries', [
            'id' => $itineraryId,
            'trip_id' => $trip->id,
            'destination_id' => $destination->id,
            'date' => '2027-08-10 00:00:00',
            'start_time' => '08:00',
            'duration' => 90,
            'note' => 'Datang pagi.',
            'sort_order' => 1,
        ]);

        $this->putJson(route('trips.itineraries.update', [$trip, $itineraryId]), [
            'date' => '2027-08-11',
            'start_time' => '10:30',
            'duration' => 120,
            'sort_order' => 1,
            'note' => 'Diperbarui.',
        ])->assertOk()->assertJsonPath('itinerary_id', $itineraryId);

        $this->assertDatabaseHas('itineraries', [
            'id' => $itineraryId,
            'date' => '2027-08-11 00:00:00',
            'start_time' => '10:30',
            'duration' => 120,
            'note' => 'Diperbarui.',
        ]);
    }

    public function test_itinerary_rejects_out_of_trip_dates_invalid_times_and_overlapping_schedules(): void
    {
        $user = $this->user('Jadwal');
        $nature = Category::forceCreate(['name' => 'Nature']);
        $first = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $second = Destination::create(['name' => 'Pantai Mertasari', 'description' => 'Pantai.']);
        $first->categories()->sync([$nature->id]);
        $second->categories()->sync([$nature->id]);
        $trip = $user->trips()->create([
            'trip_name' => 'Trip Jadwal',
            'start_date' => '2027-09-10',
            'end_date' => '2027-09-11',
        ]);
        $existing = $trip->itineraries()->create([
            'destination_id' => $first->id,
            'date' => '2027-09-10',
            'start_time' => '09:00',
            'duration' => 120,
            'sort_order' => 1,
        ]);

        $this->actingAs($user)->postJson(route('trips.itineraries.store', $trip), [
            'destination_id' => $second->id,
            'date' => '2027-09-12',
            'start_time' => '13:00',
            'duration' => 60,
            'sort_order' => 1,
        ])->assertUnprocessable()->assertJsonValidationErrors('date');

        $this->postJson(route('trips.itineraries.store', $trip), [
            'destination_id' => $second->id,
            'date' => '2027-09-10',
            'start_time' => '10:00',
            'duration' => 60,
            'sort_order' => 1,
        ])->assertUnprocessable()->assertJsonValidationErrors('start_time');

        $this->postJson(route('trips.itineraries.store', $trip), [
            'destination_id' => $second->id,
            'date' => '2027-09-10',
            'start_time' => '25:90',
            'duration' => 0,
            'sort_order' => 1,
        ])->assertUnprocessable()->assertJsonValidationErrors(['start_time', 'duration']);

        $this->assertDatabaseCount('itineraries', 1);
        $this->assertDatabaseHas('itineraries', ['id' => $existing->id]);
    }

    public function test_users_cannot_add_edit_or_delete_itineraries_on_another_users_trip(): void
    {
        $owner = $this->user('Pemilik itinerary');
        $intruder = $this->user('Pengguna lain');
        $nature = Category::forceCreate(['name' => 'Nature']);
        $destination = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $destination->categories()->sync([$nature->id]);
        $trip = $owner->trips()->create([
            'trip_name' => 'Trip Pribadi',
            'start_date' => '2027-10-01',
            'end_date' => '2027-10-02',
        ]);
        $item = $trip->itineraries()->create([
            'destination_id' => $destination->id,
            'date' => '2027-10-01',
            'start_time' => '08:00',
            'duration' => 60,
            'sort_order' => 1,
        ]);

        $this->actingAs($intruder)->postJson(route('trips.itineraries.store', $trip), [
            'destination_id' => $destination->id,
            'date' => '2027-10-01',
            'start_time' => '10:00',
            'duration' => 60,
            'sort_order' => 1,
        ])->assertNotFound();

        $this->putJson(route('trips.itineraries.update', [$trip, $item->id]), [
            'date' => '2027-10-01',
            'start_time' => '10:00',
            'duration' => 60,
            'sort_order' => 1,
        ])->assertNotFound();

        $this->delete(route('trips.itineraries.destroy', [$trip, $item->id]))->assertNotFound();
        $this->assertDatabaseHas('itineraries', ['id' => $item->id, 'trip_id' => $trip->id]);
    }

    public function test_trip_details_can_be_edited_by_its_owner_without_orphaning_saved_days(): void
    {
        $user = $this->user('Pengelola Trip');
        $trip = $user->trips()->create([
            'trip_name' => 'Trip Awal',
            'start_date' => '2027-07-01',
            'end_date' => '2027-07-02',
        ]);

        $this->actingAs($user)
            ->get(route('trips.edit', $trip))
            ->assertOk()
            ->assertSee('Trip Awal');

        $this->put(route('trips.update', $trip), [
            'trip_name' => 'Trip Diperbarui',
            'start_date' => '2027-07-02',
            'end_date' => '2027-07-04',
        ])->assertRedirect(route('trips.preferences.edit', $trip));

        $this->assertDatabaseHas('trips', ['id' => $trip->id, 'trip_name' => 'Trip Diperbarui', 'start_date' => '2027-07-02 00:00:00']);
    }

    public function test_trip_can_be_deleted_by_its_owner_and_related_itinerary_is_cascaded(): void
    {
        $owner = $this->user('Pemilik trip');
        $destination = Destination::create(['name' => 'Pantai Sanur', 'description' => 'Pantai.']);
        $trip = $owner->trips()->create([
            'trip_name' => 'Trip yang dihapus',
            'start_date' => '2027-11-01',
            'end_date' => '2027-11-02',
        ]);
        $itinerary = $trip->itineraries()->create([
            'destination_id' => $destination->id,
            'date' => '2027-11-01',
            'start_time' => '08:00',
            'duration' => 60,
            'sort_order' => 1,
        ]);

        $this->actingAs($owner)
            ->delete(route('my-trips.destroy', $trip))
            ->assertRedirect(route('my-trips.index'));

        $this->assertDatabaseMissing('trips', ['id' => $trip->id]);
        $this->assertDatabaseMissing('itineraries', ['id' => $itinerary->id]);
    }

    public function test_trip_cannot_be_deleted_by_another_user(): void
    {
        $owner = $this->user('Pemilik trip');
        $intruder = $this->user('Pengguna lain');
        $trip = $owner->trips()->create([
            'trip_name' => 'Trip pribadi',
            'start_date' => '2027-12-01',
            'end_date' => '2027-12-02',
        ]);

        $this->actingAs($intruder)
            ->get(route('trips.edit', $trip))
            ->assertNotFound();

        $this->put(route('trips.update', $trip), [
            'trip_name' => 'Trip diambil alih',
            'start_date' => '2027-12-01',
            'end_date' => '2027-12-03',
        ])->assertNotFound();

        $this->actingAs($intruder)
            ->delete(route('my-trips.destroy', $trip))
            ->assertNotFound();

        $this->assertDatabaseHas('trips', ['id' => $trip->id, 'user_id' => $owner->id]);
        $this->assertDatabaseHas('trips', ['id' => $trip->id, 'trip_name' => 'Trip pribadi']);
    }

    private function user(string $name = 'Wisatawan'): User
    {
        return User::forceCreate([
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password123',
            'role' => 'user',
        ]);
    }
}
