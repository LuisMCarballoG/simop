<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anio extends Model
{
    public $timestamps = false;
    
    protected $table = 'anio';

    protected $fillable = [
        'id',
        'oculto'
    ];

    public function elecciones()
    {
        return $this->hasMany('App\Eleccion', 'anio_id', 'id');
    }

    public function adscritos()
    {
        return $this->hasMany('App\Adscrito',  'anio_id', 'id');
    }
}