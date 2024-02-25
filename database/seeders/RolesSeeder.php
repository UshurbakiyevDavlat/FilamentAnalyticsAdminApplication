<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'analyst']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'reader']);
    }
}
