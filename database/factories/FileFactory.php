<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'path' => $this->faker->imageUrl(),
            'order' => $this->faker->randomNumber(),
            'file_type_id' => $this->faker->numberBetween(1, 3),
            'post_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
