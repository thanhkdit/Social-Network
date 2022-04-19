<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('url');
            $table->tinyInteger('type');
            $table->bigInteger('comment_id')->unsigned()->nullable(true);
            $table->bigInteger('reply_id')->unsigned()->nullable(true);
            $table->bigInteger('message_id')->unsigned()->nullable(true);
            $table->bigInteger('post_id')->unsigned()->nullable(true);
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('reply_id')->references('id')->on('replies')->onDelete('cascade');
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('images');
    }
}
