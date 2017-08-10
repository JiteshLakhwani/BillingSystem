<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {

                    return response()->json(['error' => 'Please verify your token'], 400);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'Token Expired'], 500);
            }
            $request->route()->setParameter('user', $user);
        return $next($request);
    }
}
