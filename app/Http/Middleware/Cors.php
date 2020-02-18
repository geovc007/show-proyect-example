<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
        //Url a la que se le dará acceso en las peticiones
        ->header("Access-Control-Allow-Origin", "*")
        ->header('Access-Control-Allow-Credentials', 'true')
        ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
        ->header('Access-Control-Allow-Headers', 'Origin, Accept, Content-Type, X-Requested-With');
    }
}
