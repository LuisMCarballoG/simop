<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateUsersTable extends M
{
    public function up()
    {
        S::create('users', function (B $t) {
            $t->increments('id');
            $t->string('email')->unique();
            $t->string('password');
            $t->rememberToken();
        });
    }

    public function down(){S::dropIfExists('users');}
}