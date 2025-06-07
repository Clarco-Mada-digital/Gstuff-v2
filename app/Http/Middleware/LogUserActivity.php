<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $expiresAt = now()->addMinutes(2);

            Cache::put('user-is-online-' . Auth::id(), now(), $expiresAt);
            
            // Mettre à jour le champ last_seen_at
            $lastSeen = $user->last_seen_at instanceof \Carbon\Carbon 
            ? $user->last_seen_at 
            : Carbon::parse($user->last_seen_at);

            if (!$user->last_seen_at || $lastSeen->lt(now()->subMinutes(1))) {
                $user->last_seen_at = now();
                $user->save();
            }
        }

        return $next($request);
    }
}