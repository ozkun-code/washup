<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class CheckTokenAbility
{
    public function handle(Request $request, Closure $next, ...$abilities)
    {
        $userId = $request->user()->id;
        // dd(Carbon::now());
        foreach ($abilities as $ability) {
            if ($request->user()->tokenCan($ability)) {
                $accessTokenExpiry = Redis::get("washup_app_database_{$ability}:{$userId}");
            //    dd(Carbon::now()->gt(Carbon::parse($accessTokenExpiry)));
                if (Carbon::now()->gt(Carbon::parse($accessTokenExpiry))) {
                    // Token has expired
                    return response()->json(['message' => 'Unauthorized - Token expired'], 403);
                }
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized - Invalid token '], 403);
    }
}