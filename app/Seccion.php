<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    public $timestamps = false;

    protected $table = 'seccion';

    protected $fillable = 
    [
        'id',
        'anio_id',
        'municipio_id',
        'name',
        'oculto'
    ];

    public function Anio(){
        return $this->belongsTo('App\Anio', 'anio_id', 'id');
    }

    public function municipio(){
        return $this->belongsTo('App\Municipio', 'municipio_id', 'id');
    }

    public function Rutas(){
        return $this->belongsToMany('App\Ruta', 'ruta_seccion');
    }

    public function Colonias(){
        return $this->belongsToMany('App\Colonia', 'colonia_seccion');
    }

    public function Casillas(){
        return $this->hasMany('App\Casillas', 'seccion_id', 'id');
    }

    public function adscritos(){
        return $this->hasMany('App\Adscrito', 'seccion_id', 'id');
    }

    public function eleccion(){
        return $this->hasMany('App\Eleccion', 'eleccion_id', 'id');
    }
}
 