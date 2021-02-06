<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_admin');
            $table->string('nit',100)->nullable();
            $table->string('impuesto',100)->nullable();
            $table->string('razon_social',100)->nullable();
            $table->string('codigo_postal',100)->nullable();
            $table->string('propietario',100)->nullable();
            $table->string('ciudad',100)->nullable();
            $table->string('telefono',100)->nullable();
            $table->string('correo',100)->nullable();
            $table->string('image_perfil',250)->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil');
    }
}
