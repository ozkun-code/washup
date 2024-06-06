<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! in_array(Auth::user()->role, ['employee', 'owner'])) {
            // User is not authenticated or does not have the required role
            return redirect('login'); // Redirect to login if not authorized
            // Alternatively, you could return a 403 Forbidden response
        }

        return $next($request);
    }
}
