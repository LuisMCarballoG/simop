<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    public $timestamps = false;

    protected $table = 'seccion';

    protected $fillable = [
        'id',
        'municipio_id',
        'name',
    ];

    public function municipio(){
        return $this->belongsTo('App\Municipio', 'municipio_id', 'id');
    }

    public function adscritos(){
        return $this->hasMany('App\Adscrito', 'seccion_id', 'id');
    }

    public function eleccion(){
        return $this->hasMany('App\Eleccion', 'eleccion_id', 'id');
    }
}
 