<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('feedback_id')->unsigned()->index();
            $table->tinyInteger('rating')->nullable(false);
            $table->timestamps();
        });
        Schema::table('user_feedback', function (Blueprint $table) {
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
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
        Schema::dropIfExists('user_feedback');
    }
}
