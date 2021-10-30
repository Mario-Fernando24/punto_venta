<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idingreso')->nullable();
            $table->unsignedBigInteger('idarticulo')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio',11,2)->nullable();
            $table->decimal('preciocompra',11,2)->nullable();

            $table->foreign('idingreso')->references('id')->on('ingresos')
            ->onDelete('cascade');

            $table->foreign('idarticulo')->references('id')->on('articulos')
            ->onDelete('cascade');

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
        Schema::dropIfExists('detalle_ingresos');
    }
}
