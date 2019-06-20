<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheckMiddleware
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
            $payload = static::getToken();
            if ($payload['sub'] !== 'admin') {
                throw new \Exception("Not an admin");
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]); //'No access rights'
        }
        return $next($request);
    }
}
