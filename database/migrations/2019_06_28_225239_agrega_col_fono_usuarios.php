<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregaColFonoUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::table('usuarios', function (Blueprint $table) {
            $table->string('fonoContacto', 50)->nullable();
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
        Schema::table('usuarios', function (Blueprint $table) {
          $table->dropColumn('fonoContacto');
        });
    }
}
