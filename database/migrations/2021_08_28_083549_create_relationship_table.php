<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_first')->unsigned();
            $table->bigInteger('user_second')->unsigned();
            $table->tinyInteger('type_id')->unsigned()
                    ->comment('0: friends, 1: only_chat, 2: pending_first_second, 3:pending_second_first, 4:block_first_second, 5:block_second_first, 6:block_both');
            
            // Tao lien ket
            $table->foreign('type_id')->references('id')->on('type_relationship')->onDelete('cascade');
            $table->foreign('user_first')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_second')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('relationship');
    }
}
