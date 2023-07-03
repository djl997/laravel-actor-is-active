<?php
namespace Djl997\LaravelActorIsActive\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && method_exists(auth()->user(), 'touchOnline')) {
            auth()->user()->touchOnline();
        }

        return $next($request);
    }
}