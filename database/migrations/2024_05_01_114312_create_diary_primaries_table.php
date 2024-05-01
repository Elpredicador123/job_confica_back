<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiaryPrimariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_primaries', function (Blueprint $table) {
            $table->id();
            $table->string('toa_cumpl_1ra')->nullable();
            $table->string('Cuenta primera agenda')->nullable();
            $table->string('Gestor')->nullable();
            $table->string('Contrata')->nullable();
            $table->string('Zonal')->nullable();
            $table->string('Fecha real')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diary_primaries');
    }
}
