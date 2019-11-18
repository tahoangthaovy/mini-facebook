<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'test',
                'gender' => 'male',
                'avatar' => '/img/avatars/user1.png',
                'cover' => '/img/covers/cover1.jpg',
                'email' => 'test@mailinator.com',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => 2,
                'name' => str_random(10),
                'gender' => 'male',
                'avatar' => '/img/avatars/user2.png',
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => 3,
                'name' => str_random(10),
                'gender' => 'male',
                'avatar' => '/img/avatars/user3.png',
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => 4,
                'name' => str_random(10),
                'gender' => 'male',
                'avatar' => '/img/avatars/user4.png',
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('123456'),
            ],
        ];
        foreach ($users as $user){
            DB::table('users')->insert($user);
        }

    }
}
