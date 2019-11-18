<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $posts = [
            [
                'id' => 1,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
            [
                'id' => 2,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
            [
                'id' => 3,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
            [
                'id' => 4,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
            [
                'id' => 5,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
            [
                'id' => 6,
                'post_content' => str_random(100),
                'image_path' => '/img/posts/post1.jpg',
                'user_id' => '1'
            ],
        ];

        foreach ($posts as $post){
            DB::table('posts')->insert($post);
        }
    }
}
