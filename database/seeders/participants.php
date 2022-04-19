<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class participants extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('participants')->delete();
        DB::table('participants')->insert([
            ['room_code' => '1-2', 'user_id' => 1, 'status_seen' => 1],
            ['room_code' => '1-2', 'user_id' => 2, 'status_seen' => 1],
            ['room_code' => '1-3', 'user_id' => 1, 'status_seen' => 1],
            ['room_code' => '1-3', 'user_id' => 3, 'status_seen' => 1],
            ['room_code' => '1-4', 'user_id' => 1, 'status_seen' => 1],
            ['room_code' => '1-4', 'user_id' => 4, 'status_seen' => 1],
            ['room_code' => '1-5', 'user_id' => 1, 'status_seen' => 1],
            ['room_code' => '1-5', 'user_id' => 5, 'status_seen' => 1],
        ]);
    }
}
