<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;

class JwtMiddleware
{
    use \App\Traits\JWTUtilTrait;
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
            $payload = static::getToken();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'message' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'message' => 'Token is Expired']);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $next($request);
    }
}
