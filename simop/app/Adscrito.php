<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adscrito extends Model
{
	public $timestamps = false;

    protected $table = 'adscrito';

    protected $fillable = [
        'id',
        'anio_id',
        'seccion_id',
        'militante_id',
        'lider_id',
    ];

    public function anio(){
        return $this->belongsTo('App\Anio', 'anio_id');
    }

    public function seccion(){
        return $this->belongsTo('App\Seccion', 'seccion_id');
    }

    public function militante(){
        return $this->belongsTo('App\Militante', 'militante_id');
    }

    public function lider(){
        return $this->belongsTo('App\Lider', 'lider_id');
    }
}
