<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, Role $role): Response
    {
        try {
            if (!$request->user() || !$request->user()->hasRole($role)) {
                abort(403);
            }
        } catch (RoleDoesNotExist $e) {
            // Loguer l'erreur et rediriger
            \Log::error("Role non trouvé: {$role}");
            abort(403, "Le rôle spécifié n'existe pas");
        }
        
        return $next($request);
    }
}
