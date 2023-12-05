<?php

namespace App\Models\Preescolar;

use Illuminate\Database\Eloquent\Model;

class Preescolar_agenda_colores extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['users_id', 'preesColor'];
}
