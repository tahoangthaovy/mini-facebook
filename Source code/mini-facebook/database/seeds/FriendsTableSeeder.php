<?php

use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $friends = [
            [
                'id' => 1,
                'user1' => 1,
                'user2' => 2,
                'status' => 2
            ],
            [
                'user1' => 2,
                'user2' => 1,
                'status' => 2
            ],
            [

                'user1' => 2,
                'user2' => 3,
                'status' => 1
            ],
            [
                
                'user1' => 3,
                'user2' => 2,
                'status' => 1
            ],[
                
                'user1' => 1,
                'user2' => 3,
                'status' => 2
            ],[
                
                'user1' => 3,
                'user2' => 1,
                'status' => 2
            ],
        ];

        foreach ($friends as $friend){
            DB::table('friends')->insert($friend);
        }
    }
}
