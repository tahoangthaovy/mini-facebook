<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $likes = [
            [
                'user_id' => 1,
                'post_id' => 4
            ],
            [
                'user_id' => 2,
                'post_id' => 4
            ],
            [
                'user_id' => 3,
                'post_id' => 4
            ],
            [
                'user_id' => 4,
                'post_id' => 4
            ],
            [
                'user_id' => 1,
                'post_id' => 2
            ],
            [
                'user_id' => 1,
                'post_id' => 3
            ],
            [
                'user_id' => 2,
                'post_id' => 3
            ],
            [
                'user_id' => 3,
                'post_id' => 2
            ]
        ];

        foreach ($likes as $like){
            DB::table('likes')->insert($like);
        }
    }
}
