<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = $request->user();

        
        if ($user && ($user->role === 'owner' || $user->role === 'admin')) {
            return $next($request);
        }

       
        return new Response('Forbidden - You do not have access to this resource.', 403);
    }
}