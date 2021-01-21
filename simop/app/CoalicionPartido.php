<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CoalicionPartido extends Pivot
{
    public $timestamps = false;

    protected $table = 'coalicion_partido';

    protected $fillable = [
        'id',
        'coalicion_id',
        'partido_id'
    ];
/*
    public function coalicion(){
        return $this->belongsToMany('App\Coalicion', 'coalicion', 'coalicion_id', 'coalicion_id');
    }

    public function partido(){
        return $this->belongsToMany('App\Partido', 'partido','partido_id', 'partido_id', '', '', '');
    }
    */
}