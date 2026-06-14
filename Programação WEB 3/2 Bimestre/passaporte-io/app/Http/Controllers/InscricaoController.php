<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscricaoController extends Controller
{
    /**
     * RF10 - Histórico de inscrições do participante (paginado - RNF05)
     */
    public function index()
    {
        $inscricoes = auth()->user()->inscricoes()
            ->with('category', 'organizador') // RNF04 - eager loading
            ->orderBy('event_user.created_at', 'desc')
            ->paginate(8);

        return view('inscricoes.index', compact('inscricoes'));
    }

    /**
     * RF08/RF09 - Registro de presença + geração do passaporte digital
     */
    public function store(Event $evento)
    {
        $user = auth()->user();

        // RN06 - Organizador não pode se inscrever (middleware 'participante' já bloqueia,
        // mas reforçamos aqui como segunda camada de defesa)
        if (!$user->isParticipante()) {
            return back()->with('error', 'Apenas participantes podem se inscrever em eventos.');
        }

        // RN04 - Unicidade de inscrição
        if ($evento->participantes()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Você já está inscrito neste evento.');
        }

        // RN05 - Limite absoluto de capacidade (checagem em tempo real no servidor)
        if ($evento->participantes()->count() >= $evento->capacity) {
            return back()->with('error', 'Vagas esgotadas para este evento.');
        }

        // RF09 - Geração do código alfanumérico único do ingresso
        do {
            $ticketCode = strtoupper(Str::random(10));
        } while (\App\Models\EventUser::where('ticket_code', $ticketCode)->exists());

        // RNF02 - ATTACH na tabela pivô, com timestamps automáticos
        $evento->participantes()->attach($user->id, [
            'ticket_code' => $ticketCode,
            'status' => 'confirmada',
        ]);

        return back()->with('success', "Inscrição confirmada! Seu código de ingresso é: {$ticketCode}");
    }

    /**
     * RF11 - Cancelamento de inscrição
     */
    public function destroy(Event $evento)
    {
        $user = auth()->user();

        if (!$evento->participantes()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Você não está inscrito neste evento.');
        }

        $evento->participantes()->detach($user->id);

        return back()->with('success', 'Inscrição cancelada com sucesso. Seu ingresso foi invalidado.');
    }
}