<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis; // Add this to use Redis

class CheckTokenAbility
{
    public function handle(Request $request, Closure $next, ...$abilities)
    {
        foreach ($abilities as $ability) {
            if ($request->user()->tokenCan($ability)) {
                // If the user has the ability, proceed without checking Redis
                return $next($request);
            }
        }

        // After checking all abilities, determine which Redis key to check based on the ability
        if (in_array('access_token', $abilities)) {
            $redisKey = "washup_app_database_access_token:" . $request->user()->id;
        } elseif (in_array('refresh_token', $abilities)) {
            $redisKey = "washup_app_database_refresh_token:" . $request->user()->id;
        }

        // If a Redis key was set, check its TTL
        if (isset($redisKey)) {
            $ttl = Redis::ttl($redisKey);
            if ($ttl > 0) {
                // If the token is still valid, proceed with the request
                return $next($request);
            } else {
                // If the token has expired, return a token expired message
                return response()->json(['message' => 'Token expired'], 403);
            }
        }

        // If none of the abilities match or no Redis key was set, return an unauthorized message
        return response()->json(['message' => 'Unauthorized - Invalid token'], 403);
    }
}