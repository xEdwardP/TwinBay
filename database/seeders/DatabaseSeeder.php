<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CustomerSeeder::class,
            ParkingSpaceSeeder::class,
            RateSeeder::class,
            UserSeeder::class,
            VehicleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'epineda@yopmail.com',
            'password' => Hash::make('123'),
            'first_name' => 'Edward',
            'last_name' => 'Pineda',
            'document_type' => 'DNI',
            'document_number' => '0102200000123',
            'phone' => '99887766',
            'birthday' => '1990-01-01',
            'genre' => 'Masculino',
            'address' => 'Santa Rosa de Copan, Honduras',
            'contact_name' => 'Jane Doe',
            'contact_phone' => '99776688',
            'contact_relationship' => 'Hermana',
        ])->assignRole('SUPER ADMIN');

        Setting::create([
            'name' => 'TwinBay Parking',
            'description' => 'Gestión inteligente y segura de espacios de estacionamiento',
            'branch' => 'Sucursal Principal',
            'address' => 'Calle Principal, Santa Rosa de Copan, Honduras',
            'phone1' => '26621234',
            'phone2' => '97760012',
            'logo' => 'default_logo.png',
            'logo_auto' => 'default_logo_auto.png',
            'currency' => 'HNL',
            'email' => 'twinbay@gmail.com',
            'website' => 'https://TwinBay.com',
        ]);
    }
}
