<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class type_relationship extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type_relationship')->delete();
        DB::table('type_relationship')->insert([
            ['relationship_type' => 'friends'],
            ['relationship_type' => 'only_chat'],
            ['relationship_type' => 'pending_first_second'],
            ['relationship_type' => 'pending_second_first'],
            ['relationship_type' => 'block_first_second'],
            ['relationship_type' => 'block_second_first'],
            ['relationship_type' => 'block_both'],
        ]);
    }
}
