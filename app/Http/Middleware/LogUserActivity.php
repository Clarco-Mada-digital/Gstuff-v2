<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(5);
            Cache::put('user-is-online-' . Auth::id(), now(), $expiresAt);
            
            // Mettre à jour le champ last_seen_at
            Auth::user()->update(['last_seen_at' => now()]);
        }

        return $next($request);
    }
}