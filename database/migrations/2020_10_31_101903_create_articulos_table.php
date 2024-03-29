<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idcategoria')->nullable();
            $table->string('codigo',100)->nullable();
            $table->string('nombre',100)->unique();
            $table->decimal('precio_venta',11,2)->nullable();
            $table->integer('stock')->nullable();
            $table->string('descripcion',255)->nullable();
            $table->boolean('condicion')->default(1); //default(1) es para que cuando se registre un registro en la base de dato contion sera 1 por defecto 
            $table->string('avatar',255)->nullable();

            $table->foreign('idcategoria')->references('id')->on('categorias')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('articulos');
    }
}
