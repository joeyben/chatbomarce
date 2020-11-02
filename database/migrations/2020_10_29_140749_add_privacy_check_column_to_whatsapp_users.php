<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivacyCheckColumnToWhatsappUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_users', function (Blueprint $table) {
            $table->tinyInteger('privacy_check')->after('privacy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whatsapp_users', function (Blueprint $table) {
            $table->dropColumn('privacy_check');
        });
    }
}
