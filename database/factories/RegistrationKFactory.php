<?php

namespace Database\Factories;

use App\Models\EventK;
use App\Models\RegistrationK;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RegistrationK>
 */
class RegistrationKFactory extends Factory
{
    protected $model = RegistrationK::class;

    public function definition(): array
    {
        return [
            'event_id' => EventK::factory(),
            'user_id'  => User::factory(),
            'status'   => fake()->randomElement(['pending', 'approved', 'declined']),
            'notes'    => fake()->optional()->sentence(),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn() => [
            'status'      => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn() => ['status' => 'pending']);
    }
}
