<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idProducto',10)->nullable();
            $table->string('nombre',50)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('marca',50)->nullable();
            $table->string('image',100)->nullable();
            $table->integer('precio')->nullable();
            $table->string('menu',50)->nullable();
            $table->string('subMenu',50)->nullable();
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
        Schema::dropIfExists('productos');
    }
}
