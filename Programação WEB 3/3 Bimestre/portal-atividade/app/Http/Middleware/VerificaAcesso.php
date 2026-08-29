<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificaAcesso
{
    /**
     * Verifica se o usuario informado na URL (?email=) esta autorizado
     * na tabela 'usuarios' (banco MySQL do XAMPP).
     *
     * 
     
     * Exemplos de teste:
     *  /portal?email=autorizado@teste.com   -> acesso liberado
     *  /portal?email=naoautorizado@teste.com -> acesso negado
     *  /portal                              -> acesso negado (sem email)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->query('email');

        $usuario = $email ? Usuario::where('email', $email)->first() : null;

        if ($usuario && $usuario->autorizado) {
            // Acesso liberado: middleware repassa a mensagem para o Controller
            $request->attributes->set('mensagem', 'Bem vindo ao portal');
            $request->attributes->set('usuario', $usuario);

            return $next($request);
        }

        // Acesso negado: middleware interrompe o fluxo e ja devolve a view
        // com a mensagem de erro, sem chamar o Controller
        return response()->view('portal', [
            'mensagem'    => 'Seu acesso não foi autorizado.',
            'submensagem' => 'Entrar em contato com o administrador.',
            'autorizado'  => false,
            'usuario'     => null,
        ]);
    }
}
