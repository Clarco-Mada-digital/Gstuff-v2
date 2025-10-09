<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Stevebauman\Location\Facades\Location;

class DetectCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $position = Cache::remember('ip-'.$request->ip(), now()->addDays(1), function () {
        //     return Location::get();
        // });
        
        if ($position = Location::get()) {
            $request->merge(['country_code' => $position->countryCode]);
        } else {
            $request->merge(['country_code' => 'XX']); // Valeur par défaut
        }
    
        return $next($request);
    }
}
