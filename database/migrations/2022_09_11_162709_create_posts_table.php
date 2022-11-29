<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->integer('category_id');
            $table->string('label_cate')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_company')->nullable();
            $table->tinyInteger('status')->default(1)->comment("1: active, 2: deactive");
            $table->tinyInteger('is_pin')->default(2)->comment("1: yes, 2: no");
            $table->integer('view')->nullable()->default(0);
            $table->tinyInteger('type')->nullable()->comment("1: Post, 2: Birthday, 3: Onboard, 4: Marriage");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
