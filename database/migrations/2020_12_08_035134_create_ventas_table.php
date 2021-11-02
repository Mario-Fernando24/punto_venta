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
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_anulo_venta')->nullable();
            $table->unsignedBigInteger('id_apertura_caja_usuario')->nullable();
            
            $table->string('tipo_comprobante',50)->nullable();
            $table->string('forma_pago',50)->nullable();
            $table->string('num_comprobante_pago',50)->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('impuesto',11,2)->nullable();
            $table->decimal('total',11,2)->nullable();
            $table->string('estado',50)->nullable();  
            $table->string('caba',50)->nullable();  
            $table->dateTime('fechaentregacaba')->nullable();
            $table->timestamps();



            //para saber que cliente me esta comprando
            $table->foreign('id_cliente')->references('id')->on('persona')
            ->onDelete('cascade');

            //para saber cual es el usuario responsable de esa venta
            $table->foreign('id_usuario')->references('id')->on('users')
            ->onDelete('cascade'); 

            $table->foreign('id_anulo_venta')->references('id')->on('users')
            ->onDelete('cascade');

             //para saber que apertura de caja hizo esta venta
            $table->foreign('id_apertura_caja_usuario')->references('idcaja')->on('caja')
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
