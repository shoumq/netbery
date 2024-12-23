<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multi_chats', function (Blueprint $table) {
            $table->string('img_name');
            $table->string('img_size');
            $table->string('dialog_title');
            $table->string('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multi_chats', function (Blueprint $table) {
            $table->dropColumn('img_name');
            $table->dropColumn('img_size');
            $table->dropColumn('dialog_title');
            $table->dropColumn('admin_id');
        });
    }
};
