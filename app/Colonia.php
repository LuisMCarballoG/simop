<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    public $timestamps = false;

    protected $table = 'colonia';

    protected $fillable = 
    [
        'id',
        'municipio_id',
        'name',
        'oculto'
    ];

    public function Municipio(){
        return $this->belongsTo('App\Municipio', 'municipio_id', 'id');
    }

    public function Secciones(){
    	return $this->belongsToMany('App\Seccion');
    }

    public function Coordinadores(){
        return $this->hasMany('App\Coordinadores', 'colonia_id', 'id');
    }
}
