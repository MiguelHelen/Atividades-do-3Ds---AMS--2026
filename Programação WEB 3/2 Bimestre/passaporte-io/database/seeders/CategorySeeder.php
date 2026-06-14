<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Tecnologia',
            'Música',
            'Negócios',
            'Educação',
            'Esportes',
            'Gastronomia',
            'Jogos',
            'Saúde e Bem-estar',
            'Arte e Cultura',
        ];

        foreach ($categorias as $categoria) {
            Category::firstOrCreate(['name' => $categoria]);
        }
    }
}