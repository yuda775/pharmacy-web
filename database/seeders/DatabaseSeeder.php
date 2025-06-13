<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();   
        User::factory()->create([
            'name' => 'Rena Choerunnisa',
            'email' => 'choerunnisa.rena@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Camelia',
            'email' => 'camelia@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Susilawati',
            'email' => 'susilawati@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Syntia',
            'email' => 'syntia@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Lydia',
            'email' => 'lydia@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
