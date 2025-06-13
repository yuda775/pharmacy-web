<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'Swarga Farma 1',
            'address' => 'Jl. Swarga Farma 1, Jakarta',
            'latitude' => -7.034031147036652,
            'longitude' => 107.60974511533462
        ]);

        Location::create([
            'name' => 'Swarga Farma 2',
            'address' => 'Jl. Swarga Farma 2, Jakarta',
            'latitude' => -7.038508804779252,
            'longitude' => 107.60582899604317
        ]);
    }
}
