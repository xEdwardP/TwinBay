<?php

namespace Database\Seeders;

use App\Models\ParkingSpace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingSpaceSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['disponible', 'ocupado', 'en mantenimiento'];

        foreach (range(1, 50) as $i) {
            ParkingSpace::create([
                'parking_number' => $i,
                'parking_status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
