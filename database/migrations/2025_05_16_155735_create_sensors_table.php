<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sensors')) {
            Schema::create('sensors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->float('temperature')->nullable();
                $table->integer('air_quality')->nullable();
                $table->float('light')->nullable();
                $table->integer('sound')->nullable();
                $table->boolean('system_on')->default(true);
                $table->boolean('fault')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
