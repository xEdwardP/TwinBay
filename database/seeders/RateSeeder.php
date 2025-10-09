<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [];

        $names = ['regular', 'nocturna', 'feriados', 'fin de semana'];

        $baseHourCosts = [
            'regular' => 20,
            'nocturna' => 22,
            'feriados' => 25,
            'fin de semana' => 23,
        ];

        $baseDayCosts = [
            'regular' => 480,
            'nocturna' => 528,
            'feriados' => 600,
            'fin de semana' => 552,
        ];

        foreach ($names as $name) {
            $base = $baseHourCosts[$name];

            for ($hour = 1; $hour <= 23; $hour++) {
                $cost = $base * $hour;

                $grace = match (true) {
                    $hour >= 1 && $hour <= 8 => 10,
                    $hour >= 9 && $hour <= 18 => 15,
                    $hour >= 19 && $hour <= 23 => 20,
                };

                $rates[] = [
                    'name' => $name,
                    'type' => 'por hora',
                    'cost' => $cost,
                    'quantity' => $hour,
                    'grace_period_minutes' => $grace,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($names as $name) {
            $base = $baseDayCosts[$name];

            for ($day = 1; $day <= 7; $day++) {
                $cost = $base * $day;

                $rates[] = [
                    'name' => $name,
                    'type' => 'por dia',
                    'cost' => $cost,
                    'quantity' => $day,
                    'grace_period_minutes' => 720,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('rates')->insert($rates);
    }
}
