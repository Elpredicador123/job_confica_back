<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_requerimiento');
            $table->string('tipo_requerimiento');
            $table->string('tipo_cierre');
            $table->string('cf');
            $table->string('tecnico');
            $table->string('zonal');
            $table->string('contrata');
            $table->date('fecha');
            $table->string('usuario');
            $table->string('numero_referencia');
            $table->string('efectividad');
            $table->string('nota_nps');
            $table->string('detractor');
            $table->text('observaciones');
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
        Schema::dropIfExists('orders');
    }
}
