<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('idrol');
            //$table->string('name');
            $table->string('email')->unique();
            $table->string('usuario')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('condicion')->default(1); 
            $table->date('fechaNacimiento')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
           // DB::table('users')->insert(array('id'=>'1','idrol'=>'1','email'=>'mariofer@gmail.com','usuario'=>'mariofer','password'=>'$2y$10$mcfpQKKZjyRmtw7UeSok9OE2qg8ztfuUlTtHa0lE1v7Vt0WFWfc9W'));

        




            $table->foreign('id')->references('id')->on('persona')
            ->onDelete('cascade')
            ->onUpdate('cascade');
 

            $table->foreign('idrol')->references('id')->on('roles')
            ->onDelete('cascade')
            ->onUpdate('cascade');


        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
