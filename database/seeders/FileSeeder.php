<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\FileType;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileType::factory(4)->create();
        File::factory(10)->create();
    }
}
