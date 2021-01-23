<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    public $timestamps = false;

    protected $table = 'historial';

    protected $fillable = [
        'id',
        'users_id',
        'movimiento',
        'fecha'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}