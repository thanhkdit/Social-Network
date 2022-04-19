<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class messages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('messages')->delete();
        DB::table('messages')->insert([
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 00, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 10, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 20, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 30, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 40, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 50, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 00, 16), 'room_code'=> '1-3','user_id' => 3],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 10, 16), 'room_code'=> '1-3','user_id' => 1],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 20, 16), 'room_code'=> '1-4','user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 30, 16), 'room_code'=> '1-4','user_id' => 4],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 40, 16), 'room_code'=> '1-4','user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 50, 16), 'room_code'=> '1-4','user_id' => 4],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 00, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 10, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 20, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 30, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 40, 16), 'room_code'=> "1-2",'user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 50, 16), 'room_code'=> "1-2",'user_id' => 2],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 00, 16), 'room_code'=> '1-4','user_id' => 4],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 10, 16), 'room_code'=> '1-4','user_id' => 1],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 20, 16), 'room_code'=> '1-4','user_id' => 4],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 30, 16), 'room_code'=> '1-4','user_id' => 1],
            ['message' => 'Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh Toi la ban cua Thanh ', 'time' => Carbon::create(2021, 7, 18, 14, 40, 16), 'room_code'=> '1-4','user_id' => 1],
            ['message' => 'Toi la Thanh', 'time' => Carbon::create(2021, 7, 18, 14, 50, 16), 'room_code'=> '1-4','user_id' => 1]
            
        ]);
    }
}
