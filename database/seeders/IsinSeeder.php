<?php

namespace Database\Seeders;

use App\Models\Isin;
use Illuminate\Database\Seeder;

class IsinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Isin::factory(10)->create();
    }
}
