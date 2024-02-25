<?php

namespace Database\Seeders;

use App\Models\HorizonDataset;
use Illuminate\Database\Seeder;

class HorizonDatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HorizonDataset::factory(10)->create();
    }
}
