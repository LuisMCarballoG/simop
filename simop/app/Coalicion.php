<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coalicion extends Model
{
    public $timestamps = false;

    protected $table = 'coalicion';

    protected $fillable = [
        'id',
        'name_small',
        'name',
        'foto',
        'oculto'
    ];
/*
    public function coalicion_partido(){
        return $this->hasMany('App\CoalicionPartido');
    }
*/
    public function partidos()
    {
        return $this->belongsToMany('App\Partido');
    }

    public function elecciones(){
        return $this->hasMany('App\Eleccion', 'partido_id', 'id');
    }
}