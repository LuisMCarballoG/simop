<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
	public $timestamps = false;

    protected $table = 'entidad';

    protected $fillable = 
    [
    	'id',
    	'name',
    	'name_short',
    	'oculto',
    ];

    public function Municipios(){
    	return $this->hasMany('App\Municipio', 'entidad_id', 'id');
    }
}
