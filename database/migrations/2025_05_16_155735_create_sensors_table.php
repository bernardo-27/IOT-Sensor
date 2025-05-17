<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    if (!Schema::hasTable('sensors')) {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->float('temperature')->nullable();
            $table->integer('air_quality')->nullable();
            $table->float('light')->nullable();
            $table->integer('sound')->nullable();
            $table->boolean('system_on')->default(true);
            $table->boolean('fault')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
