<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsParticipante
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isParticipante()) {
            abort(403, 'Apenas Participantes podem realizar inscrições.');
        }

        return $next($request);
    }
}