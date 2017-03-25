<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (!$request->user()->hasRole($role)) {
            $response = [
                'status_code' => 401,
                'status_message' => 'anda tidak memliki hak akses',
            ];
            return response()->json($response,401);
        }

        return $next($request);
    }
}
