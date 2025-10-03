<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Vehicle;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $customers = Customer::pluck('id')->toArray();

        if (empty($customers)) {
            $this->command->warn('No hay clientes en la base de datos. Se necesitan para asociar vehículos.');
            return;
        }

        $usedPlates = [];

        for ($i = 0; $i < 50; $i++) {
            do {
                $plate = strtoupper('HND-' . $faker->unique()->numerify('###'));
            } while (in_array($plate, $usedPlates));

            $usedPlates[] = $plate;

            Vehicle::create([
                'customer_id' => $faker->randomElement($customers),
                'license_plate' => $plate,
                'brand' => $faker->randomElement(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Kia', 'Hyundai', null]),
                'model' => $faker->word(),
                'color' => $faker->safeColorName(),
                'vehicle_type' => $faker->randomElement(['moto', 'carro', 'camion', 'otro']),
            ]);
        }
    }
}
