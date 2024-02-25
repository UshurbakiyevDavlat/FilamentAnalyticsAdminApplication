<?php

namespace Database\Factories;

use App\Models\TypePaper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TypePaper>
 */
class TypePaperFactory extends Factory
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
        ];
    }
}
