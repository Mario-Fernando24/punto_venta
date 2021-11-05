<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormaPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forma_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',50) ->unique();
            $table->boolean('condicion')->default(1); 
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Efectivo'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Credito y Efectivo'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Credito'));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forma_pago');
    }
}




