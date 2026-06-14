<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'organizador@passaporte.io'],
            [
                'name' => 'Organizador Teste',
                'password' => Hash::make('password'),
                'role' => 'organizador',
            ]
        );

        User::firstOrCreate(
            ['email' => 'participante@passaporte.io'],
            [
                'name' => 'Participante Teste',
                'password' => Hash::make('password'),
                'role' => 'participante',
            ]
        );
    }
}