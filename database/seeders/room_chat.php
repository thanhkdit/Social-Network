<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class room_chat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('room_chat')->delete();
        DB::table('room_chat')->insert([
            ['room_code' => '1-2', 'room_name' => 'Room chat 0', 'room_image' => 'room_image_1', 'type' => 0],
            ['room_code' => '1-3', 'room_name' => 'Room chat 2', 'room_image' => 'room_image_2', 'type' => 0],
            ['room_code' => '1-4', 'room_name' => 'Room chat 3', 'room_image' => 'room_image_3', 'type' => 0],
            ['room_code' => '1-5', 'room_name' => 'Room chat 4', 'room_image' => 'room_image_4', 'type' => 0],
            ['room_code' => '2-3', 'room_name' => 'Room chat 5', 'room_image' => 'room_image_5', 'type' => 0],
            ['room_code' => '2-4', 'room_name' => 'Room chat 6', 'room_image' => 'room_image_6', 'type' => 1],
            ['room_code' => '2-5', 'room_name' => 'Room chat 7', 'room_image' => 'room_image_7', 'type' => 1],
            ['room_code' => '3-4', 'room_name' => 'Room chat 8', 'room_image' => 'room_image_8', 'type' => 1],
            ['room_code' => '3-5', 'room_name' => 'Room chat 9', 'room_image' => 'room_image_9', 'type' => 1],

        ]);
    }
}
