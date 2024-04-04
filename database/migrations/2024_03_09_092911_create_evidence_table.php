<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->id();
            $table->text('Día')->nullable();
            $table->text('SEM')->nullable();
            $table->text('Semana')->nullable();
            $table->text('SEM1')->nullable();
            $table->text('Mes')->nullable();
            $table->text('AÑO')->nullable();
            $table->text('Marca temporal')->nullable();
            $table->text('Requerimiento')->nullable();
            $table->text('Contrata')->nullable();
            $table->text('TIPO DE ATENCION')->nullable();
            $table->text('ZONA')->nullable();
            $table->text('EXISTE FOTO DEL TRIPLEXOR')->nullable();
            $table->text('Opción "SI" se Visualiza Triplexor')->nullable();
            $table->text('Si está "Bien Instalado" Validar Motivo')->nullable();
            $table->text('Si está "Mal Instalado" Validar Motivo')->nullable();
            $table->text('C_TRIPLEXOR')->nullable();
            $table->text('EXISTE FOTO DE ROSETA OPTICA')->nullable();
            $table->text('Opción Tiene Roseta Roseta')->nullable();
            $table->text('Si está "Mal Instalado" Validar Motivo2')->nullable();
            $table->text('Si está "Bien Instalado" Validar Motivo3')->nullable();
            $table->text('C_ROSETA OPTICA')->nullable();
            $table->text('Existe Foto de HGU o El Cable Modem')->nullable();
            $table->text('estado HGU o El Cable Modem')->nullable()->comment('El HGU o El Cable Modem esta Libre de Obstáculos y muestra Triplexor o Roseta Optica');
            $table->text('Observaciones de Falsa Informacion')->nullable();
            $table->text('Comentar Observaciones')->nullable();
            $table->text('C_HGU-CABLE MODEM')->nullable();
            $table->text('Existe Foto de Spliter')->nullable();
            $table->text('Opcion tiene Splitter')->nullable();
            $table->text('Tiene Carga F')->nullable();
            $table->text('Tiene Filtro de Retorno')->nullable();
            $table->text('C_SPLITER')->nullable();
            $table->text('Existe Carga de Foto de VoIP')->nullable();
            $table->text('Opción Tiene VoiP')->nullable();
            $table->text('estado numero Linea 1 y TOA')->nullable()->comment('El *Numero de Linea 1* coincide con el numero asignado en TOA componetes');
            $table->text('Marca *Resgitrada* esta Ok')->nullable();
            $table->text('Tiene Direccion IPv4 asignada')->nullable();
            $table->text('C_VOIP')->nullable();
            $table->text('RESULTADO')->nullable();
            $table->text('RESULTADO HISPAM')->nullable();
            $table->text('EECC')->nullable();
            $table->text('CODTECNICO')->nullable();
            $table->text('FECHA')->nullable();
            $table->text('JEFATURA')->nullable();
            $table->text('ZONA4')->nullable();
            $table->text('Cod_Cliente')->nullable();
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
        Schema::dropIfExists('evidence');
    }
}
