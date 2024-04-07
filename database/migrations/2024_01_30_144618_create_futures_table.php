<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('futures', function (Blueprint $table) {
            $table->id();
            $table->text('Carnet')->nullable();//queda
            $table->text('Técnico')->nullable();//queda
            $table->text('Subtipo de Actividad')->nullable();//queda
            $table->text('Número de Petición')->nullable();//queda
            $table->text('Fecha de Cita')->nullable();//queda
            $table->text('Time Slot')->nullable();//queda
            $table->text('Nodo_zona')->nullable();//queda
            $table->text('Estado actividad')->nullable();//queda
            $table->text('Tipo de Cita')->nullable();//queda
            $table->text('Cod_liq')->nullable();//queda
            $table->text('tipo_inefectiva')->nullable();//queda
            $table->text('Código de Cliente')->nullable();//queda
            $table->text('Fecha Registro de Actividad en TOA')->nullable();//queda
            $table->text('Tipo de Tecnología Legados')->nullable();//queda
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
        Schema::dropIfExists('futures');
    }
}
