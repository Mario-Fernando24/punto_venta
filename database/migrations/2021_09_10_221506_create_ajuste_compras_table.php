<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjusteComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_compra');
            $table->unsignedBigInteger('id_caja');
            $table->unsignedBigInteger('id_users');
            $table->decimal('efectivo',11,2);
            $table->decimal('credito',11,2);
            $table->decimal('abono',11,2);
            $table->boolean('estado')->default(1);
            $table->timestamps();


            $table->foreign('id_compra')->references('id')->on('ingresos'); 
            $table->foreign('id_caja')->references('id')->on('caja'); 
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
        Schema::dropIfExists('ajuste_compras');
    }
}
