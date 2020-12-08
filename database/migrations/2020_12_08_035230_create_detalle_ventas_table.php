<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_articulo');
            $table->integer('cantidad');
            $table->decimal('precio',11,2);
            $table->decimal('descuento',11,2);


            $table->foreign('id_venta')->references('id')->on('ventas')
            ->onDelete('cascade'); 

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
        Schema::dropIfExists('detalle_ventas');
    }
}
