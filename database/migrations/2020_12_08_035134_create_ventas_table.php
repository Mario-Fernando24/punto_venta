<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_usuario ');
            $table->string('tipo_comprobante',50)->nullable();
            $table->string('forma_pago',50)->nullable();
            $table->string('num_comprobante_pago',50)->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('impuesto',11,2);
            $table->decimal('total',11,2);
            $table->string('estado ',50)->nullable();  
            $table->timestamps();



            //para saber que cliente me esta comprando
            $table->foreign('id_cliente')->references('id')->on('persona')
            ->onDelete('cascade');

            //para saber cual es el usuario responsable de esa venta
            $table->foreign('id_usuario')->references('id')->on('users')
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
        Schema::dropIfExists('ventas');
    }
}
