<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjusteVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste_venta', function (Blueprint $table) {
           
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_venta')->nullable();
            $table->unsignedBigInteger('id_caja')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->decimal('efectivo',11,2)->nullable();
            $table->decimal('credito',11,2)->nullable();
            $table->decimal('datafono',11,2)->nullable();
            $table->decimal('tranferencia',11,2)->nullable();
            $table->string('observacionFormaPago',250) ->unique();
            $table->boolean('estado')->default(1); 
            $table->timestamps();

            $table->foreign('id_venta')->references('id')->on('ventas'); 
            $table->foreign('id_caja')->references('idcaja')->on('caja');
            $table->foreign('id_users')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajuste_venta');
    }
}
