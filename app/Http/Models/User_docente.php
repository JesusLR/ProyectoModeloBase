<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User_docente extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_docentes';

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
        'password',
        'remember_token',
        'token',
        'maternal',
        'preescolar',
        'primaria',
        'secundaria',
        'bachiller',
        'superior',
        'posgrado',
        'educontinua',
        'departamento_cobranza',
        'campus_cme',
        'campus_cva',
        'campus_cch'
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

    public function empleado()
    {
        return $this->belongsTo('App\Http\Models\Empleado');
    }
}
