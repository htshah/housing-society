<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;

class JwtMiddleware
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
            // Test if valid jwt token is provided or not
            $payload = JWTAuth::parseToken();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired']);
            } else {
                return response()->json(['error' => 'Something is wrong', 'message' => $e->getMessage()]);
            }
        }
        return $next($request);
    }
}
