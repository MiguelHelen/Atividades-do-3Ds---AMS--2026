<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessMiddleware
{
    /**
     * Verifica se o usuário/requisição tem permissão de acesso.
     * Se não tiver, redireciona para a view de "acesso negado"
     * exibindo a mensagem exigida pela atividade.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Regra de exemplo: aqui você pode trocar por qualquer
        // condição real (ex: Auth::check(), permissão no banco, etc).
        // Por padrão, deixamos como "false" para forçar a exibição
        // da tela de acesso negado durante os testes.
        $temPermissao = false;

        if (!$temPermissao) {
            return response()->view('acesso-negado', [
                'mensagem' => 'Você não tem permissão para acessar este site.',
                'submensagem' => 'Favor entrar em contato com o administrador.',
            ], 403);
        }

        return $next($request);
    }
}
