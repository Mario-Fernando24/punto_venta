<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjusteinventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajusteinventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_anulo_ajuste')->nullable();
            $table->unsignedBigInteger('id_apertura_caja_usuario')->nullable();
            $table->string('tipo_ajuste')->nullable();
            $table->string('motivo')->nullable();
            $table->decimal('impuesto',11,2)->nullable();
            $table->decimal('total',11,2)->nullable();
            $table->boolean('estado')->default(1); 
            $table->timestamps();


            $table->foreign('id_usuario')->references('id')->on('users'); 
            $table->foreign('id_anulo_ajuste')->references('id')->on('users');
            $table->foreign('id_apertura_caja_usuario')->references('idcaja')->on('caja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajusteinventario');
    }
}
