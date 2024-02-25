<?php

namespace Database\Factories;

use App\Models\FileType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FileType>
 */
class FileTypeFactory extends Factory
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
            'extension' => $this->faker->fileExtension(),
            'mime_type' => $this->faker->mimeType(),
            'icon' => $this->faker->imageUrl(),
        ];
    }
}
