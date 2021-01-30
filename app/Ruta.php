<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    public $timestamps = false;

    protected $table = 'ruta';

    protected $fillable = 
    [
        'id',
        'name',
    ];

    public function Secciones(){
    	return $this->belongsToMany('App\Seccion');
    }
}
