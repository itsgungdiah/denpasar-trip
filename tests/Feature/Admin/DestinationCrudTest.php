<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DestinationCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_view_edit_and_delete_a_destination(): void
    {
        Storage::fake('public');

        $admin = User::forceCreate([
            'name' => 'Admin DenpasarTrip',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $category = Category::forceCreate(['name' => 'Culture']);

        $payload = [
            'name' => 'Museum Bali',
            'description' => 'Museum tentang sejarah dan budaya Bali.',
            'image' => UploadedFile::fake()->image('museum.jpg'),
            'opening_hours' => json_encode([
                'schedules' => [[
                    'days' => ['Senin', 'Selasa'],
                    'hours' => '08.00-17.00',
                ]],
                'notes' => 'Tutup saat hari libur tertentu.',
            ], JSON_THROW_ON_ERROR),
            'entrance_fee' => json_encode([
                'type' => 'fixed',
                'amount' => 25000,
                'min' => null,
                'max' => null,
                'notes' => 'Harga dewasa.',
            ], JSON_THROW_ON_ERROR),
            'average_spending' => json_encode([
                'type' => 'range',
                'amount' => null,
                'min' => 15000,
                'max' => 50000,
                'notes' => '',
            ], JSON_THROW_ON_ERROR),
            'google_maps_url' => '',
            'categories' => [$category->id],
        ];

        $createResponse = $this->actingAs($admin)
            ->post(route('admin.destinations.store'), $payload);

        $createResponse->assertRedirect(route('admin.destinations.index'));

        $destination = Destination::query()->firstOrFail();
        $this->assertSame('Museum Bali', $destination->name);
        $this->assertSame('08.00-17.00', $destination->opening_hours['schedules'][0]['hours']);
        $this->assertSame(25000, $destination->entrance_fee['amount']);
        $this->assertSame(15000, $destination->average_spending['min']);
        $this->assertNull($destination->google_maps_url);
        $this->assertTrue($destination->categories->contains($category));
        Storage::disk('public')->assertExists($destination->image);

        $this->get(route('admin.destinations.index'))
            ->assertOk()
            ->assertSee('Museum Bali')
            ->assertSee('Culture');

        $this->get(route('admin.destinations.edit', $destination))
            ->assertOk()
            ->assertSee('08.00-17.00')
            ->assertSee('25000')
            ->assertSee('15000');

        $oldImage = $destination->image;
        $updatePayload = [
            ...$payload,
            'image' => UploadedFile::fake()->image('museum-updated.jpg'),
            'opening_hours' => json_encode([
                'schedules' => [[
                    'days' => ['Sabtu', 'Minggu'],
                    'hours' => '09.00-16.00',
                ]],
                'notes' => '',
            ], JSON_THROW_ON_ERROR),
            'entrance_fee' => json_encode([
                'type' => 'range',
                'amount' => null,
                'min' => 10000,
                'max' => 30000,
                'notes' => '',
            ], JSON_THROW_ON_ERROR),
            'average_spending' => json_encode([
                'type' => null,
                'amount' => null,
                'min' => null,
                'max' => null,
                'notes' => 'Belum ada estimasi.',
            ], JSON_THROW_ON_ERROR),
        ];

        $this->put(route('admin.destinations.update', $destination), $updatePayload)
            ->assertRedirect(route('admin.destinations.index'));

        $destination->refresh();
        $this->assertSame('09.00-16.00', $destination->opening_hours['schedules'][0]['hours']);
        $this->assertSame(10000, $destination->entrance_fee['min']);
        $this->assertSame('Belum ada estimasi.', $destination->average_spending['notes']);
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($destination->image);

        $imageToDelete = $destination->image;
        $this->delete(route('admin.destinations.destroy', $destination))
            ->assertRedirect(route('admin.destinations.index'));

        $this->assertDatabaseMissing('destinations', ['id' => $destination->id]);
        Storage::disk('public')->assertMissing($imageToDelete);
    }
}
