<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoalicionesTable extends Migration
{
    public function up()
    {
        Schema::create('coalicion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_small');
            $table->string('name');
            $table->longText('foto')->nullable();
            $table->enum('oculto', ['Y', 'N'])->default('N');
        });
    }

    public function down(){
        Schema::dropIfExists('coalicion');
    }
}
