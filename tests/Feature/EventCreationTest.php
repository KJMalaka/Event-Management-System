<?php

namespace Tests\Feature;

use App\Models\CategoryK;
use App\Models\EventK;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_view_the_create_event_page(): void
    {
        $organizer = User::factory()->organizer()->create();

        $response = $this->actingAs($organizer)->get(route('events.create'));

        $response->assertOk();
        $response->assertSee('Create New Event');
    }

    public function test_organizer_can_store_a_new_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $category = CategoryK::factory()->create();

        $payload = [
            'title' => 'Cape Town Jazz Night',
            'description' => 'A premium live jazz showcase inspired by Cape Town nightlife and festival culture.',
            'category_id' => $category->id,
            'location' => 'Cape Town, South Africa',
            'venue' => 'CTICC',
            'start_date' => now()->addWeek()->format('Y-m-d\TH:i'),
            'end_date' => now()->addWeek()->addHours(3)->format('Y-m-d\TH:i'),
            'capacity' => 1200,
            'price' => 850,
            'status' => 'published',
            'requires_approval' => '1',
        ];

        $response = $this->actingAs($organizer)->post(route('events.store'), $payload);

        $event = EventK::query()->firstOrFail();

        $response->assertRedirect(route('events.show', $event->slug, false));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('events', [
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Cape Town Jazz Night',
            'location' => 'Cape Town, South Africa',
            'venue' => 'CTICC',
            'capacity' => 1200,
            'price' => 850,
            'status' => 'published',
        ]);
    }

    public function test_organizer_can_publish_and_cancel_an_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = EventK::factory()->draft()->create([
            'organizer_id' => $organizer->id,
        ]);

        $publishResponse = $this->actingAs($organizer)->patch(route('events.publish', $event->slug));

        $publishResponse->assertRedirect();
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'published',
        ]);

        $cancelResponse = $this->actingAs($organizer)->patch(route('events.cancel', $event->slug));

        $cancelResponse->assertRedirect();
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'cancelled',
        ]);
    }
}