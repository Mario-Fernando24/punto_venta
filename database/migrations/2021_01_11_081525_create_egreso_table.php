<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso', function (Blueprint $table) {
            $table->bigIncrements('idegreso');
            $table->unsignedBigInteger('id_caja')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->string('tipo_egreso',100)->nullable()->nullable();
            $table->decimal('valor_egreso',11,2)->nullable()->nullable();
            $table->string('motivo_egreso',100)->nullable()->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();


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
        Schema::dropIfExists('egreso');
    }
}
