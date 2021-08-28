<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormapagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formapago', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('nombre',50) ->unique();
            $table->boolean('condicion')->default(1); 
            $table->timestamps();

        });
        DB::table('formapago')->insert(array('id'=>'1','nombre'=>'Efectivo'));
        DB::table('formapago')->insert(array('id'=>'2','nombre'=>'Credito y Efectivo'));
        DB::table('formapago')->insert(array('id'=>'3','nombre'=>'Credito'));
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formapago');
    }
}
