<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Permission_module_user;
use App\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $controlador)
    {
        $user = Auth::user();
        $modulo = Modules::where('slug', $controlador)->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id',$modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;
        // return $next($request);
        if ($permiso == 'D') { //PERMISO DE SOLO CONSULTAS
            alert()->error('Ups...', 'Sin privilegios!')->showConfirmButton()->autoClose(5000);
            // return redirect()->to($controlador);
            return redirect()->back();
        }

        return $next($request);
    }
}
