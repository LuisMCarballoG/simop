<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Militante extends Model
{
    public $timestamps = false;

     protected $table = 'militante';

    protected $fillable = [
        'id',
        'name',
        'apat',
        'amat',
        'dir',
        'ife'
    ];

    public function adscritos(){
        return $this->hasMany('App\Adscrito', 'militante_id', 'id');
    }
}
 