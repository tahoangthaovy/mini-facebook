<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'id' => 1,
                'comment_content' => str_random(20),
                'user_id' => '1',
                'post_id' => '1'
            ],
            [
                'comment_content' => str_random(20),
                'user_id' => '2',
                'post_id' => '1'
            ],
            [
                'comment_content' => str_random(20),
                'user_id' => '3',
                'post_id' => '1'
            ],
            [
                'comment_content' => str_random(20),
                'user_id' => '4',
                'post_id' => '1'
            ],
        ];

        foreach ($comments as $comment){
            DB::table('comments')->insert($comment);
        }
    }
}
