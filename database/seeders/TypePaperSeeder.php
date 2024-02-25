<?php

namespace Database\Seeders;

use App\Models\TypePaper;
use Illuminate\Database\Seeder;

class TypePaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypePaper::factory(2)->create();
    }
}
