<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'password' => 'password',
            'role' => 'manager',
        ]);

        User::factory(10)->create([
            'password' => 'password',
            'role' => 'storekeeper',
        ]);

        User::factory(10)->create([
            'password' => 'password',
            'role' => 'salesman',
        ]);

        User::factory(10)->create([
            'password' => 'password',
            'role' => 'cleaning_staff',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }
}
