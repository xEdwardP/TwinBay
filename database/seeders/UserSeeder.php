<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Juan Carlos Bodoque',
            'email' => 'jbodoque@yopmail.com',
            'password' => Hash::make('12345678'),
            'first_name' => 'Juan Carlos',
            'last_name' => 'Bodoque',
            'document_type' => 'Carnet de extranjero',
            'document_number' => '0401200000777',
            'phone' => '98005432',
            'birthday' => '2000-07-07',
            'genre' => 'Masculino',
            'address' => 'Santa Rosa de Copan, Honduras',
            'contact_name' => 'Julian Casablancas',
            'contact_phone' => '933366777',
            'contact_relationship' => 'Maestro',
        ])->assignRole('ADMINISTRADOR');

        User::create([
            'name' => 'Kurt Donald Cobain',
            'email' => 'kcobain@yopmail.com',
            'password' => Hash::make('12345678'),
            'first_name' => 'Kurt Donald',
            'last_name' => 'Cobain',
            'document_type' => 'Pasaporte',
            'document_number' => '0102196700027',
            'phone' => '99613377',
            'birthday' => '1967-02-20',
            'genre' => 'Masculino',
            'address' => 'Santa Rosa de Copan, Honduras',
            'contact_name' => 'Frances Bean Cobain',
            'contact_phone' => '97334899',
            'contact_relationship' => 'Hija',
        ])->assignRole('ADMINISTRADOR');

        User::create([
            'name' => 'Ana Janneth Garcia Escobar',
            'email' => 'agarcia@yopmail.com',
            'password' => Hash::make('12345678'),
            'first_name' => 'Ana Janneth',
            'last_name' => 'Garcia Escobar',
            'document_type' => 'Pasaporte',
            'document_number' => '0102199805061',
            'phone' => '93445521',
            'birthday' => '1998-02-05',
            'genre' => 'Femenino',
            'address' => 'Santa Rosa de Copan, Honduras',
            'contact_name' => 'Maria Mercedez',
            'contact_phone' => '96313144',
            'contact_relationship' => 'Madre',
        ])->assignRole('OPERADOR');

        User::create([
            'name' => 'Laura Marcela Perez Chinchilla',
            'email' => 'lmarcela@yopmail.com',
            'password' => Hash::make('12345678'),
            'first_name' => 'Laura Marcela',
            'last_name' => 'Perez Chinchilla',
            'document_type' => 'Licencia de conducir',
            'document_number' => '0709199005068',
            'phone' => '99225588',
            'birthday' => '1990-02-05',
            'genre' => 'Femenino',
            'address' => 'Santa Rosa de Copan, Honduras',
            'contact_name' => 'Mario Castellanos',
            'contact_phone' => '98776630',
            'contact_relationship' => 'Padre',
        ])->assignRole('OPERADOR');
    }
}
