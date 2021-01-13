<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonoCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_creditos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_Credito');
            $table->unsignedBigInteger('idusers');
            $table->decimal('montoAbonar',11,2)->nullable();
            $table->string('observacion',100)->nullable();
            $table->boolean('estado')->default(0);
            $table->timestamps();


            $table->foreign('id_Credito')->references('idCredito')->on('creditos'); 
            $table->foreign('idusers')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abono_creditos');
    }
}
