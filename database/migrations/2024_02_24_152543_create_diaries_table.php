<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaries', function (Blueprint $table) {
            $table->id();
            $table->text('fecha_tde')->nullable();
            $table->text('apptNumber')->nullable();
            $table->text('STATUS')->nullable();
            $table->text('DATE')->nullable();
            $table->text('diaSemana')->nullable();
            $table->text('estado_fin')->nullable();
            $table->text('XA_APPOINTMENT_SCHEDULER')->nullable();
            $table->text('toa_intervalo_tiempo')->nullable();
            $table->text('cita_ini')->nullable();
            $table->text('cita_fin')->nullable();
            $table->text('toa_cumplimiento')->nullable();
            $table->text('fec_ini')->nullable();
            $table->text('fec_fin')->nullable();
            $table->text('actividad')->nullable();
            $table->text('xa_route')->nullable();
            $table->text('XA_DISTRICT_NAME')->nullable();
            $table->text('region_new')->nullable();
            $table->text('jef_cmr')->nullable();
            $table->text('lima_prov')->nullable();
            $table->text('resourceId')->nullable();
            $table->text('activityId')->nullable();
            $table->text('bucket')->nullable();
            $table->text('Valido')->nullable();
            $table->text('nume')->nullable();
            $table->text('deno')->nullable();
            $table->text('eecc')->nullable();
            $table->text('NODO')->nullable();
            $table->text('TROBA')->nullable();
            $table->text('Liberado')->nullable();
            $table->text('MigCarMas')->nullable();
            $table->text('Priority')->nullable();
            $table->text('Nombre_empresa')->nullable();
            $table->text('Nombre_canal')->nullable();
            $table->text('hgu')->nullable();
            $table->text('Usuario_Cancela')->nullable();
            $table->text('Contr_mig')->nullable();
            $table->text('A_STOPEO')->nullable();
            $table->text('usu_com')->nullable();
            $table->text('completados')->nullable();
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
        Schema::dropIfExists('diaries');
    }
}
