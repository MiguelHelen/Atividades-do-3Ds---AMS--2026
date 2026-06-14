<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * RF12 - Vitrine de eventos / RF13 - Filtro por categoria
     * RNF04 - Eager loading (category, organizador) evita N+1
     * RNF05 - Paginação nativa
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizador']) // RNF04
            ->where('date_time', '>=', now())
            ->orderBy('date_time', 'asc');

        if ($request->filled('categoria')) {
            $query->where('category_id', $request->integer('categoria'));
        }

        $eventos = $query->paginate(9)->withQueryString(); // RNF05

        $categorias = Category::orderBy('name')->get();

        return view('eventos.index', compact('eventos', 'categorias'));
    }

    /**
     * RF14 - Tela de detalhes do evento
     */
    public function show(Event $evento)
    {
        $evento->load(['category', 'organizador']); // RNF04

        $jaInscrito = false;
        if (auth()->check() && auth()->user()->isParticipante()) {
            $jaInscrito = $evento->participantes()
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('eventos.show', compact('evento', 'jaInscrito'));
    }
}