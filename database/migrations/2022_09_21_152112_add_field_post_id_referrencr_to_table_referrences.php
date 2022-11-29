<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPostIdReferrencrToTableReferrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrences', function (Blueprint $table) {
            $table->string('post_id_referrence')->after('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referrences', function (Blueprint $table) {
            $table->string('post_id_referrence');
        });
    }
}
