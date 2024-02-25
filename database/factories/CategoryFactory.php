<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'order' => $this->faker->numberBetween(1, 100),
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'img' => $this->faker->imageUrl(),
            'parent_id' => null,
            'status_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
