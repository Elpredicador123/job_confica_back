<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicals', function (Blueprint $table) {
            $table->id();
            $table->text('Documento')->nullable();
            $table->text('Nro_Documento')->nullable();
            $table->text('Apellido_paterno')->nullable();
            $table->text('Apellido_materno')->nullable();
            $table->text('Nombres')->nullable();
            $table->text('Fecha_Nacimiento')->nullable();
            $table->text('Nacionalidad')->nullable();
            $table->text('Cargo')->nullable();
            $table->text('Genero')->nullable();
            $table->text('Contrata')->nullable();
            $table->text('Estado')->nullable();
            $table->text('Carnet')->nullable();
            $table->text('Nombre_Completo')->nullable();
            $table->text('Zonal')->nullable();
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
        Schema::dropIfExists('technicals');
    }
}
