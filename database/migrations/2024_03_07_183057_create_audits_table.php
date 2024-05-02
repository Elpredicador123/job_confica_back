<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->text('Carnet de Tecnico')->nullable();
            $table->text('Se Realizo Inspeccion a Tecnico')->nullable();
            $table->text('Fotocheck2')->nullable();
            $table->text('Uniforme2')->nullable();
            $table->text('Tiene PON Power Meter2')->nullable();
            $table->text('Tiene Jumper Preconectorizado2')->nullable();
            $table->text('Tiene Cortadora de fibra2')->nullable();
            $table->text('Tiene Peladora de Drop2')->nullable();
            $table->text('Tiene Peladora de Acrilato2')->nullable();
            $table->text('Tiene One Click2')->nullable();
            $table->text('Tiene Alcohol Isopropilico2')->nullable();
            $table->text('Tiene Paños Para Limpiar2')->nullable();
            $table->text('MES')->nullable();
            $table->text('AÑO')->nullable();
            $table->text('CONFORMIDAD')->nullable();
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
        Schema::dropIfExists('audits');
    }
}
