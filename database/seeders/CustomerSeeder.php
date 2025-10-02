<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(2, 30) as $i) {
            Customer::create([
                'name' => $faker->name(),
                'document_type' => $faker->numberBetween(1, 4),
                'document_number' => (int) $faker->unique()->numerify('##############'),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'genre' => $faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            ]);
        }
    }
}
