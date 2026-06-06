<?php

namespace Database\Factories;

use App\Models\CategoryK;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CategoryK>
 */
class CategoryKFactory extends Factory
{
    protected $model = CategoryK::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Technology', 'Music', 'Sports', 'Education', 'Business',
            'Health', 'Arts', 'Food', 'Travel', 'Science',
        ]);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => fake()->sentence(),
            'color'       => fake()->hexColor(),
        ];
    }
}
