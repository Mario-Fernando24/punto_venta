<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100)->unique();
            $table->string('tipo_documento',100)->nullable();
            $table->string('num_documento',100)->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('telefono',100)->nullable();
            $table->string('email',100)->unique();
            $table->string('latitud')->nullable(); 
            $table->string('longitud')->nullable(); 
            $table->date('fechaNacimiento')->nullable();
            $table->timestamps();

           // DB::table('persona')->insert(array('id'=>'1','nombre'=>'mariofer','tipo_documento'=>'3242343','num_documento'=>'3242343','direccion'=>'3242343','telefono'=>'3242343','email'=>'marifer@gmail.com'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
