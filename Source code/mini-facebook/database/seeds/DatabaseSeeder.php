<?php

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
        $this->call(PostsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(FriendsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
    }
}
