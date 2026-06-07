<?php

namespace Database\Factories;

use App\Models\CategoryK;
use App\Models\EventK;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EventK>
 */
class EventKFactory extends Factory
{
    protected $model = EventK::class;

    public function definition(): array
    {
        $saEvents = [
            'Amapiano All-Stars Live',
            'Loyiso Comedy Night',
            'Heritage Day Festival',
            'Cape Town Jazz Festival',
            'National Arts Festival',
            'Braai Culture Expo',
            'South African Music Awards',
            'Soweto Theatre Festival',
            'Design Indaba Conference',
            'Cape Town Fashion Week',
            'Durban Beachfront Jazz',
            'Johannesburg Street Fest',
            'Pride in the Park Johannesburg',
            'Kruger Park Wildlife Experience',
            'Mandela Day Community Celebration',
            'Carnival Sa Cape Town',
            'SA Wine & Music Festival',
            'Reggae in the Park',
            'Kwaito Night Live',
            'Poetry & Wine Evening',
        ];

        $saVenues = [
            'FNB Stadium, Soweto',
            'Baxter Theatre, Cape Town',
            'Braamfontein, Johannesburg',
            'CTICC, Cape Town',
            'Civic Theatre, Johannesburg',
            'Durban ICC',
            'Sandton Convention Centre',
            'V&A Waterfront, Cape Town',
            'Pretoria National Theatre',
            'Montecasino Theatre, Johannesburg',
        ];

        $saProvinces = [
            'Gauteng',
            'Western Cape',
            'KwaZulu-Natal',
            'Limpopo',
            'Mpumalanga',
            'North West',
            'Free State',
            'Eastern Cape',
            'Northern Cape',
        ];

        $title     = fake()->randomElement($saEvents);
        $startDate = fake()->dateTimeBetween('+1 week', '+5 months');
        $endDate   = clone $startDate;
        $endDate->modify('+' . rand(2, 48) . ' hours');

        return [
            'organizer_id'      => User::factory()->organizer(),
            'category_id'       => CategoryK::factory(),
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . Str::random(6),
            'description'       => fake()->paragraphs(3, true),
            'location'          => fake()->randomElement($saVenues),
            'venue'             => fake()->randomElement($saProvinces) . ' | ' . fake()->randomElement(['Theatre', 'Arena', 'Convention Centre', 'Stadium', 'Music Hall']),
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'capacity'          => fake()->numberBetween(50, 5000),
            'price'             => fake()->randomElement([0, 150, 250, 350, 500, 850, 1500]),
            'status'            => 'published',
            'requires_approval' => fake()->boolean(30),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn() => ['status' => 'draft']);
    }

    public function free(): static
    {
        return $this->state(fn() => ['price' => 0]);
    }

    public function past(): static
    {
        return $this->state(function () {
            $start = fake()->dateTimeBetween('-6 months', '-2 weeks');
            $end   = clone $start;
            $end->modify('+' . rand(1, 5) . ' days');
            return [
                'start_date' => $start,
                'end_date'   => $end,
                'status'     => 'completed',
            ];
        });
    }
}
