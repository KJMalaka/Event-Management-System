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
        $title     = fake()->sentence(4);
        $startDate = fake()->dateTimeBetween('+1 week', '+5 months');
        $endDate   = clone $startDate;
        $endDate->modify('+' . rand(2, 48) . ' hours');

        return [
            'organizer_id'      => User::factory()->organizer(),
            'category_id'       => CategoryK::factory(),
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . Str::random(6),
            'description'       => fake()->paragraphs(3, true),
            'location'          => fake()->city() . ', ' . fake()->country(),
            'venue'             => fake()->company() . ' ' . fake()->randomElement(['Hall', 'Centre', 'Arena', 'Stadium']),
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'capacity'          => fake()->numberBetween(20, 500),
            'price'             => fake()->randomElement([0, 0, 50, 100, 150, 200, 500]),
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
