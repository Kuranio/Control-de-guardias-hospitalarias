<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('fechadenacimiento')->nullable();
            $table->string('vacaciones1')->nullable();
            $table->string('vacaciones2')->nullable();
            $table->string('vacaciones3')->nullable();
            $table->string('vacaciones4')->nullable();
            $table->string('vacaciones5')->nullable();
            $table->string('vacaciones6')->nullable();
            $table->string('vacaciones7')->nullable();
            $table->string('vacaciones8')->nullable();
            $table->string('vacaciones9')->nullable();
            $table->string('vacaciones10')->nullable();
            $table->string('jornada')->nullable();
            $table->string('dni')->unique();
            $table->string('seccion')->nullable();
            $table->string('festivos')->nullable();
            $table->string('password');
            $table->string('contraseña');
            $table->boolean('is_admin');
            $table->boolean('haceGuardias')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
