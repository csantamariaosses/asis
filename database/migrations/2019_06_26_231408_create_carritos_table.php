<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idSession',60);
            $table->string('usuario',100);
            $table->string('idProducto',30);
            $table->string('nombre',60);
            $table->integer('precio');
            $table->integer('cantidad');
            $table->integer('subtotal');
            $table->date('fecha');
            $table->string('estado',20);

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
        Schema::dropIfExists('carritos');
    }
}
