<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->bigIncrements('idcaja');
            $table->unsignedBigInteger('id_vendedor');
            $table->string('Cajainicial')->nullable();
            $table->string('Fecha',100)->nullable();
            $table->string('Cajaactual',100)->nullable();
            $table->string('obs_apertura',100)->nullable();
            $table->string('obs_final',100)->nullable();
            $table->json('dinero_inicial')->nullable();
            $table->json('dinero_final')->nullable();
            $table->timestamps();



            //para saber cual es el vendedor responsable de esta caja
            $table->foreign('id_vendedor')->references('id')->on('users')
            ->onDelete('cascade'); 

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja');
    }
}
