<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TickerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->word,
            'short_name' => $this->faker->word,
        ];
    }
}
