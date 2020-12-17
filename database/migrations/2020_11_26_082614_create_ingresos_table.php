<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idproveedor');
            $table->unsignedBigInteger('idusuario');
            $table->unsignedBigInteger('id_anulo_ingreso')->nullable();
            $table->string('tipo_comprobante',50)->nullable();
            $table->string('serie_comprobante',50)->nullable();
            $table->string('num_comprobante',50)->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('impuesto',11,2);
            $table->decimal('total',11,2);
            $table->string('estado',50)->nullable();

            $table->timestamps();



            $table->foreign('idproveedor')->references('id')->on('proveedores')
            ->onDelete('cascade');

            $table->foreign('idusuario')->references('id')->on('users')
            ->onDelete('cascade');


            $table->foreign('id_anulo_ingreso')->references('id')->on('users')
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
        Schema::dropIfExists('ingresos');
    }
}
