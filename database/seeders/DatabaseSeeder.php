<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(users::class);
        $this->call(room_chat::class);
        $this->call(messages::class);
        $this->call(participants::class);
        $this->call(type_relationship::class);
        $this->call(relationship::class);
    }
}
