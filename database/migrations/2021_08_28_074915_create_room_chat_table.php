<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_chat', function (Blueprint $table) {
            
            $table->string('room_code')->nullable(false)
                    ->comment('id-id, vd: 3-4');
            $table->string('room_name',255)->default('');
            $table->string('room_image',255)->default('');
            $table->tinyInteger('type')->nullable(false)
                    ->comment('0: personal, 1: group');

            $table->primary('room_code');
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
        Schema::dropIfExists('room_chat');
    }
}
