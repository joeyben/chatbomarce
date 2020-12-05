<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNachrichtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_nachricht', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('nachricht_id')->unsigned()->index();
            $table->timestamps();
        });
        Schema::table('user_nachricht', function (Blueprint $table) {
            $table->foreign('nachricht_id')->references('id')->on('nachrichtens')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('whatsapp_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_nachricht');
    }
}
