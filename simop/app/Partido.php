<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
	public $timestamps = false;

    protected $table = 'partido';

    protected $fillable = [
        'id',
        'name_small',
        'name',
        'foto',
        'oculto'
    ];

    public function coaliciones(){
        return $this->belongsToMany('App\Coalicion');
    }

    public function elecciones(){
        return $this->hasMany('App\Eleccion', 'partido_id', 'id');
    }

    /*
    public function coalicion_has_partido(){
        return $this->hasMany('App\CoalicionPartido', 'partido_id', 'id');
    }
    */
}