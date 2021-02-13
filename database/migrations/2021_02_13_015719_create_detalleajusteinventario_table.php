<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleajusteinventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleajusteinventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_ajusteinventario')->nullable();
            $table->unsignedBigInteger('id_articulo')->nullable();
            $table->string('tipo_ajuste')->nullable();
            $table->decimal('precio',11,2)->nullable();
            $table->integer('cantidad_existencia')->nullable();
            $table->integer('cantidad_entran')->nullable();
            $table->integer('cantidad_quedan')->nullable();
            $table->timestamps();


            $table->foreign('id_ajusteinventario')->references('id')->on('ajusteinventario'); 
            $table->foreign('id_articulo')->references('id')->on('articulos'); 


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleajusteinventario');
    }
}
