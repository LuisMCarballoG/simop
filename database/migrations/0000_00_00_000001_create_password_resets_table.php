<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreatePasswordResetsTable extends M
{
    public function up()
    {
        S::create('password_resets', function (B $t) {
            $t->string('email')->index();
            $t->string('token');
            $t->timestamp('created_at')->nullable();
        });
    }

    public function down(){S::dropIfExists('password_resets');}
}