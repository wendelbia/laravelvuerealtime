<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            //relacionamento da tabela
            $table->integer('user_id')->unsigned()->index();
            //text para caber vários caractere
            $table->text('body');
            $table->timestamps();
            //chave estrangeira
            $table->foreign('user_id')
            //referência da tabela 
                        ->references('id')
                        //qual tabela relacionada
                        ->on('users')
                        //deletando em cascata
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
        Schema::dropIfExists('messages');
    }
}
