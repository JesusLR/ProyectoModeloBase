<?php

namespace App\Models\Preescolar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preescolar_agenda extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'color', 'textColor', 'start', 'user_id', 'created_at']; 


    protected $dates = [
        'deleted_at',
    ];
}
