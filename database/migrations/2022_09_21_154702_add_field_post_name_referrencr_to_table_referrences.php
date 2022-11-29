<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPostNameReferrencrToTableReferrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrences', function (Blueprint $table) {
            $table->string('post_name_referrence')->after('post_id_referrence');
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
            $table->string('post_name_referrence');
        });
    }
}
