<?php

namespace Database\Factories;

use App\Models\HorizonDataset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HorizonDataset>
 */
class HorizonDatasetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'currentPrice' => $this->faker->randomFloat(2, 0, 100),
            'openPrice' => $this->faker->randomFloat(2, 0, 100),
            'targetPrice' => $this->faker->randomFloat(2, 0, 100),
            'potential' => $this->faker->randomFloat(2, 0, 100),
            'analyzePrice' => $this->faker->randomFloat(2, 0, 100),
            'horizon' => $this->faker->numberBetween(1, 100),
            'status' => fake()->randomElement([true, false]),
            'recommend' => $this->faker->randomElement(['buy', 'sell', 'hold', 'default']),
            'risk' => $this->faker->randomElement(['low', 'medium', 'high', 'very_high', 'default']),
            'ticker_id' => $this->faker->numberBetween(1, 10),
            'isin_id' => $this->faker->numberBetween(1, 10),
            'sector_id' => $this->faker->numberBetween(1, 10),
            'country_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
