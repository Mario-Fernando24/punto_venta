<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->bigIncrements('idCredito');
            $table->unsignedBigInteger('idVenta')->nullable();
            $table->unsignedBigInteger('idCliente')->nullable();
            $table->decimal('deuda',11,2)->nullable();
            $table->string('observacion',100)->nullable();
            $table->boolean('estado')->default(0);
            $table->timestamps();


            $table->foreign('idVenta')->references('id')->on('ventas'); 
            $table->foreign('idCliente')->references('id')->on('persona'); 


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditos');
    }
}
