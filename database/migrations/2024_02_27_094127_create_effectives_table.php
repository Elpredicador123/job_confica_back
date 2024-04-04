<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEffectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effectives', function (Blueprint $table) {
            $table->id();
            $table->text('cod_liq')->nullable();
            $table->text('des_liq')->nullable();
            $table->text('tip_visita')->nullable();
            $table->text('Llave')->nullable();
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
        Schema::dropIfExists('effectives');
    }
}
