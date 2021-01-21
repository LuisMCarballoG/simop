<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eleccion extends Model
{
    public $timestamps = false;

    protected $table = 'eleccion';

    protected $fillable = [
        'id',
        'anio_id',
        'partido_id',
        'coalicion_id',
        'seccion_id',
        'total'
    ];

    /** Agregamos una llave foranea a cada funcion ya que tenemos varias llaves foraneas y Eloquent se confunde y no puede tomar una llave foranea por defecto. **/
    public function anio(){
        return $this->belongsTo('App\Anio', 'anio_id');
    }

    public function partido(){
        return $this->belongsTo('App\Partido', 'partido_id');
    }

    public function coalicion(){
        return $this->belongsTo('App\Coalicion', 'coalicion_id');
    }

    public function seccion(){
        return $this->belongsTo('App\Seccion', 'seccion_id');
    }
}
