<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * RF04 - Listagem de eventos do organizador 
     */
    public function index()
    {
        $eventos = Event::where('user_id', auth()->id())
            ->withCount('participantes')
            ->orderBy('created_at', 'desc')
            ->paginate(8); // RNF05

        return view('admin.eventos.index', compact('eventos'));
    }

    /**
     * RF05 - Formulário de criação
     */
    public function create()
    {
        $categorias = Category::orderBy('name')->get();
        return view('admin.eventos.create', compact('categorias'));
    }

    /**
     * RF05 - Persistir novo evento
     */
    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);

        // RNF09 - Ofuscação do nome do arquivo (Laravel já gera hash automaticamente)
        if ($request->hasFile('banner')) {
            $validated['banner_path'] = $request->file('banner')->store('banners', 'public'); // RNF08
        }

        unset($validated['banner']);

        // RN07 - Vínculo automático ao usuário autenticado 
        $validated['user_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    /**
     * RF06 - Formulário de edição
     */
    public function edit(Event $evento)
    {
        $this->authorizeOwnership($evento); // RN09 / 2.3.3

        $categorias = Category::orderBy('name')->get();
        return view('admin.eventos.edit', compact('evento', 'categorias'));
    }

    /**
     * RF06 - Atualizar evento
     */
    public function update(Request $request, Event $evento)
    {
        $this->authorizeOwnership($evento); // RN09 / 2.3.3

        $validated = $this->validateEvent($request, $evento);

        if ($request->hasFile('banner')) {
            
            if ($evento->banner_path) {
                Storage::disk('public')->delete($evento->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('banners', 'public');
        }

        unset($validated['banner']);

        $evento->update($validated);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * RF07 - Excluir evento (com salvaguarda RN03)
     */
    public function destroy(Event $evento)
    {
        $this->authorizeOwnership($evento); // RN09 / 2.3.3

        // RN03 - Não pode excluir evento com participantes inscritos
        if ($evento->participantes()->count() > 0) {
            return redirect()->route('admin.eventos.index')
                ->with('error', 'Não é possível excluir este evento: já existem participantes inscritos. Cancele as inscrições ou contate o suporte.');
        }

        if ($evento->banner_path) {
            Storage::disk('public')->delete($evento->banner_path);
        }

        $evento->delete();

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    /**
     * RN09 - Proteção de propriedade regressiva: bloqueia acesso a evento de terceiros
     */
    private function authorizeOwnership(Event $evento): void
    {
        if ($evento->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para acessar este evento.');
        }
    }

    /**
     * Regras de validação compartilhadas (criação e edição)
     * RN01, RN02
     */
    private function validateEvent(Request $request, ?Event $evento = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'date_time' => ['required', 'date', 'after:now'], // RN01 - sem datas retroativas
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'banner' => [
                $evento ? 'nullable' : 'required',
                'image',          // RN02 - obrigatoriamente uma imagem
                'max:2048',        // RN02 - limite de 2MB
            ],
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve ter pelo menos :min caracteres.',
            'description.required' => 'A descrição é obrigatória.',
            'description.min' => 'A descrição deve ter pelo menos :min caracteres.',
            'date_time.required' => 'A data e hora são obrigatórias.',
            'date_time.date' => 'Informe uma data e hora válidas.',
            'date_time.after' => 'A data do evento não pode ser retroativa. Escolha uma data futura.',
            'location.required' => 'A localização é obrigatória.',
            'capacity.required' => 'A quantidade de vagas é obrigatória.',
            'capacity.integer' => 'A quantidade de vagas deve ser um número inteiro.',
            'capacity.min' => 'O evento deve ter pelo menos 1 vaga.',
            'category_id.required' => 'Selecione uma categoria.',
            'category_id.exists' => 'Categoria inválida.',
            'banner.required' => 'O banner do evento é obrigatório.',
            'banner.image' => 'O arquivo enviado deve ser uma imagem.',
            'banner.max' => 'A imagem não pode ultrapassar 2MB.',
        ]);
    }
}