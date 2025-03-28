<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('Nombres')->nullable();
            $table->string('Apellido_Paterno')->nullable();
            $table->string('Apellido_Materno')->nullable();
            $table->string('Dni')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['Nombres', 'Apellido_Paterno', 'Apellido_Materno', 'Dni', 'email']);
        });
    }
}
