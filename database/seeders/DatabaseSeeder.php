<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SectorSeeder::class,
            IsinSeeder::class,
            TickerSeeder::class,
            CountrySeeder::class,
            HorizonDatasetSeeder::class,
            RolesSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            TypePaperSeeder::class,
            CategorySeeder::class,
            PostTypeSeeder::class,
            PostSeeder::class,
            FileSeeder::class,
        ]);
    }
}
