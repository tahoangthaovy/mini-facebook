<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = [
            [
                'sent_user' => 1,
                'received_user' => 2,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 3,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 3,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],[
                'sent_user' => 2,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 2,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 2,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 2,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 3,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 3,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 3,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'received_user' => 2,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 2,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 2,
                'received_user' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 2,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 2,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 4,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 4,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 3,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 1,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ],
            [
                'sent_user' => 3,
                'group_id' => 1,
                'message_content' => str_random(10) . ' ' . str_random(10)
            ]
        ];

        foreach ($messages as $message){
            DB::table('messages')->insert($message);
        }
    }
}
