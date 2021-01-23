<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lider extends Model
{
    public $timestamps = false;

    protected $table = 'lider';

    protected $fillable = [
        'id',
        'name',
        'apat',
        'amat',
        'ife',
        'dir'
    ];

    public function adscritos(){
        return $this->hasMany('App\Adscrito', 'lider_id', 'id');
    }
}
