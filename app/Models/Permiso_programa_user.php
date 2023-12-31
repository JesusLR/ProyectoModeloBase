<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso_programa_user extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permisos_programas_user';

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
        'user_id',
        'programa_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }
}