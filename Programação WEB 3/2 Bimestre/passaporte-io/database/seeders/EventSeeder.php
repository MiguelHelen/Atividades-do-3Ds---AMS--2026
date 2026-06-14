<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizador = User::where('role', 'organizador')->first();

        $tecnologia = Category::where('name', 'Tecnologia')->first();
        $musica = Category::where('name', 'Música')->first();
        $negocios = Category::where('name', 'Negócios')->first();

        $eventos = [
            [
                'category_id' => $tecnologia->id,
                'title' => 'Laravel Conf Brasil 2026',
                'description' => 'O maior encontro de desenvolvedores Laravel do país. Palestras, workshops e networking com especialistas.',
                'date_time' => now()->addDays(15),
                'location' => 'Centro de Convenções, São Paulo - SP',
                'capacity' => 100,
            ],
            [
                'category_id' => $musica->id,
                'title' => 'Festival de Verão Sound Wave',
                'description' => 'Três dias de música ao vivo com artistas nacionais e internacionais em um cenário à beira-mar.',
                'date_time' => now()->addDays(30),
                'location' => 'Praia Grande, SP',
                'capacity' => 500,
            ],
            [
                'category_id' => $negocios->id,
                'title' => 'Workshop de Empreendedorismo Digital',
                'description' => 'Aprenda estratégias práticas para validar e escalar seu negócio digital com mentores experientes.',
                'date_time' => now()->addDays(7),
                'location' => 'Hub de Inovação, Curitiba - PR',
                'capacity' => 50,
            ],
        ];

        foreach ($eventos as $evento) {
            Event::firstOrCreate(
                ['title' => $evento['title']],
                array_merge($evento, ['user_id' => $organizador->id])
            );
        }
    }
}