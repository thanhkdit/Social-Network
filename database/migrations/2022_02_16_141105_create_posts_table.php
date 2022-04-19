<?php

use Carbon\Carbon;
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
            $table->longText('content')->nullable();
            $table->integer('nums_like')->default(0);
            $table->integer('reaction')->default(0);
            $table->integer('nums_share')->default(0);
            $table->string('feeling')->nullable();
            $table->string('location')->nullable();
            $table->integer('type');
            $table->dateTime('time')->default(Carbon::now('Asia/Ho_Chi_Minh'));
            $table->bigInteger('author')->unsigned();
            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
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
