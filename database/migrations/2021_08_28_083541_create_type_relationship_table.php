<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_relationship', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('relationship_type',100)->nullable(false)
                    ->comment('0: friends, 1: only_chat, 2: pending_first_second, 3:pending_second_first, 4:block_first_second, 5:block_second_first, 6:block_both');
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
        Schema::dropIfExists('type_relationship');
    }
}
