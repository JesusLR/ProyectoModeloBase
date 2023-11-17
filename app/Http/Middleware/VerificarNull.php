<?php

namespace App\Http\Middleware;

use Closure;

class VerificarNull
{
    /**
     Verifica si el campo es NULL y en vez de eso manda un empty string, ''
     NULL -> ''
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->input() as $key => $value) {
            if($value == NULL){
                $request->request->set($key,'');
            }
        }
        return $next($request);
    }
}
