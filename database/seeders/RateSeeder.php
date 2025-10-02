<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['regular', 'nocturna', 'fin de semana', 'feriados'];
        $types = ['por hora', 'por dia'];

        foreach (range(1, 20) as $i) {
            Rate::create([
                'name' => $names[array_rand($names)],
                'type' => $types[array_rand($types)],
                'cost' => rand(50, 500) / 10,
                'quantity' => rand(1, 24),
                'grace_period_minutes' => rand(5, 30),
            ]);
        }
    }
}
