<?php

namespace App\Models;

use App\Http\Models\Bachiller\Bachiller_empleados;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Models\Modules;
use App\Models\Permission_module_user;
use App\Models\Permission;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empleado_id',
        'username',
        'password',
        'token',
        'maternal',
        'preescolar',
        'secundaria',
        'bachiller',
        'superior',
        'posgrado',
        'educontinua',
        'departamento_cobranza',
        'departamento_control_escolar',
        'departamento_sistemas',
        'campus_cme',
        'campus_cva',
        'campus_cch',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'token',
    ];

    protected $dates = [
        'deleted_at',
    ];


     /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot()
   {
     parent::boot();
     if(Auth::check()){

        static::deleting(function($table) {
            foreach ($table->permisos()->get() as $permiso) {
                $permiso->delete();
            }
        });
      }
   }

    public function empleado()
    {
        return $this->belongsTo('App\Http\Models\Empleado');
    }

    public function primaria_empleado()
    {
        return $this->belongsTo('App\Http\Models\Primaria\Primaria_empleado', "empleado_id");
    }

    public function secundaria_empleado()
    {
        return $this->belongsTo('App\Http\Models\Secundaria\Secundaria_empleados', "empleado_id");
    }

    public function bachiller_empleado()
    {
        return $this->belongsTo('App\Http\Models\Bachiller\Bachiller_empleados', "empleado_id");
    }


    public function permisos()
    {
        return $this->hasMany('App\Http\Models\Permiso_programa_user');
    }

    public function matriculas_anteriores()
    {
        return $this->hasMany('App\Http\Models\MatriculaAnterior');
    }

    public static function permiso($controlador)
    {
        $user = Auth::user();
        $modulo = Modules::where('slug',$controlador)->first();
        $permisos = Permission_module_user::where('user_id',$user->id)->where('module_id',$modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;
        return $permiso;
    }


    public function isAdmin(string $permiso)
    {
        return in_array($this->permiso($permiso), ['A', 'B']);
    }
}
