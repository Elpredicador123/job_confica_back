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
            $table->text('C_TRIPLEXOR')->nullable();
            $table->text('C_ROSETA OPTICA')->nullable();
            $table->text('C_HGU-CABLE MODEM')->nullable();
            $table->text('C_SPLITER')->nullable();
            $table->text('C_VOIP')->nullable();
            $table->text('RESULTADO')->nullable();
            $table->text('CODTECNICO')->nullable();
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
