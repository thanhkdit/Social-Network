<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable(false)->unique();
            $table->string('password')->nullable(false);
            $table->string('name',255)->nullable();
            $table->string('avatar',255)->nullable()->default('');
            $table->string('phone',255)->nullable()->default('');
            $table->string('address',255)->nullable()->default('');
            $table->string('description',255)->nullable()->default('');
            $table->string('introduce',255)->nullable()->default('');
            $table->string('calendar_id',255)->nullable();
            $table->date('birthday')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->tinyInteger('status_verify')->default(0)
                    ->comment('0: not verified, 1: verified');

            $table->tinyInteger('status_online')->default(0)
                    ->comment('0: offline, 1: online');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
