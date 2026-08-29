<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Usuario Autorizado',
            'email' => 'autorizado@teste.com',
            'autorizado' => true,
        ]);

        Usuario::create([
            'nome' => 'Usuario Nao Autorizado',
            'email' => 'naoautorizado@teste.com',
            'autorizado' => false,
        ]);
    }
}
