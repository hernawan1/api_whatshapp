<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SelectAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check the environment and set the appropriate middleware
        $authDriver = env('AUTH_DRIVER', 'sanctum'); // Default to 'sanctum' if not set in .env

        // Set driver otentikasi berdasarkan env
        if ($authDriver == 'keycloak') {
            Auth::setDefaultDriver('keycloak');
            $request->setUserResolver(function () {
                return Auth::guard('keycloak')->user();
            });

            // Jalankan middleware `loadKeycloakToken` dengan meneruskan `$next`
            return App::make(LoadKeycloakToken::class)->handle($request, $next);
        } else {
            Auth::setDefaultDriver('sanctum');
            $request->setUserResolver(function () {
                return Auth::guard('sanctum')->user();
            });
        }

        return $next($request);
    }
}
