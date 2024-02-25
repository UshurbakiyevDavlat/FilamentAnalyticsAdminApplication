<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'post_type_id' => $this->faker->numberBetween(1, 2),
            'horizon_dataset_id' => $this->faker->numberBetween(1, 10),
            'author_id' => $this->faker->numberBetween(1, 10),
            'type_paper_id' => $this->faker->numberBetween(1, 2),
            'status_id' => $this->faker->numberBetween(1, 2),
            'category_id' => $this->faker->numberBetween(1, 10),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
