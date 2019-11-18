<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'user_ids' => '[1,2,3]',
                'name' => 'We are the best',
                'group_avatar' => '/img/groups/group-no-image.png'
            ],
            [
                'user_ids' => '[2,3]',
                'name' => 'Odd family',
                'group_avatar' => '/img/groups/group-no-image.png'
            ],
            [
                'user_ids' => '[2,3,4]',
                'name' => 'Trip to London',
                'group_avatar' => '/img/groups/group-no-image.png'
            ],
            [
                'user_ids' => '[1,2]',
                'name' => 'Yoloooooooo',
                'group_avatar' => '/img/groups/group-no-image.png'
            ]
        ];

        foreach ($groups as $group){
            DB::table('groups')->insert($group);
        }
    }
}
