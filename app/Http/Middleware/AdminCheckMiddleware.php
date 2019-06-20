<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class AdminCheckMiddleware
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
            $payload = JWTAuth::decode(JWTAuth::getToken())->toArray();
            if ($payload['sub'] !== 'admin') {
                throw new \Exception("Not an admin");
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]); //'No access rights'
        }
        return $next($request);
    }
}
