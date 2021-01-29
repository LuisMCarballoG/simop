<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public $timestamps = false;

    protected $table = 'municipio';

    protected $fillable = ['id', 'entidad_id', 'name'];

    public function secciones(){
        return $this->hasMany('App\Seccion', 'municipio_id', 'id');
    }

    public function Entidad(){
    	return $this->belongsTo('App\Entidad', 'entidad_id', 'id');
    }
}