<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        $user = Auth::user();

        // Vérifiez si le type d'utilisateur est autorisé
        if ($user && in_array($user->u_type, $types)) {
            return $next($request);
        }

        // Redirigez ou renvoyez une erreur selon vos besoins
        return redirect()->route('vendre.index'); // page de vente
    }
}