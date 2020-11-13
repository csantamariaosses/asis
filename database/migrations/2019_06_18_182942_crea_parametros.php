<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaParametros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('parametros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut',10)->nullable();;
            $table->string('nombre',50)->nullable();
            $table->string('email',60)->nullable();
            $table->string('fonoContacto',30)->nullable();
            $table->string('fonoWhasap',30)->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('direccionWeb',50)->nullable();
            $table->string('hostMail',50)->nullable();
            $table->string('hostMailUser',50)->nullable()
            $table->string('hostMailPass',60)->nullable();
            $table->integer('hostMailPuerto')->nullable();


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
        //
        Schema::dropIfExists('parametros');
    }
}
