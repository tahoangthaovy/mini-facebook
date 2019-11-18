<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getNewMessages(Request $request){
//        $request_data = json_decode($request->getContent(), true);
        $request_data = $request->all();
        $user_id = $request_data['user_id'];
        $current_user_id = Auth::user()->id;
        $messages = Message::whereIn('sent_user', [$user_id, $current_user_id])
            ->whereIn('received_user', [$user_id, $current_user_id])
            ->orderBy('id', 'asc')
            ->get();
        echo json_encode($messages);
        die;
    }

    public function getNewGroupMessages(Request $request){
        $request_data = $request->all();
        $group_id = $request_data['group_id'];
        $messages = Message::where('group_id', $group_id)
            ->where('received_user', 0)
            ->orderBy('id', 'asc')
            ->get();
        foreach ($messages as $message){
            $message['sent_user_data'] = User::findOrFail($message->sent_user);
        }
        echo json_encode($messages);
    }

    public function addNewMessage(Request $request){

        $input = json_decode($request->getContent(), true);
        $input['sent_user'] = Auth::user()->id;
        Message::create($input);
        echo json_encode($input);
        die;
    }

    public static function getGroupMessages($group_id){
        $messages = Message::where('received_user', 0)->where('group_id', $group_id)->orderBy('id', 'asc')->get();
        foreach ($messages as $message){
            $message['sent_user_data'] = User::findOrFail($message->sent_user);
        }
        return $messages;
    }

    static public function getNewMessageFromContact ($sent_user_id){
        $current_user = Auth::user();
        $messages = Message::where('sent_user', $sent_user_id)
            ->where('is_new', 1)
            ->where('received_user', $current_user->id)
            ->get();
        return $messages;
    }
    static public function getNewMessageFromGroup ($group_id){
        $current_user = Auth::user();
        $messages = Message::where('group_id', $group_id)
            ->where('is_new', 1)
            ->where('sent_user', '!=', $current_user->id)
            ->get();
        return $messages;
    }

    public function countNewContactMessage(Request $request){
        $input = json_decode($request->getContent(), true);
        $sent_user_ids = $request->sent_user_ids;
        $result = [];
        $result['counts'] = [];
        $result['sent_user_ids'] = [];
        foreach ($sent_user_ids as $sent_user_id){
            $count_contact_message = count(self::getNewMessageFromContact($sent_user_id));
            array_push($result['sent_user_ids'], $sent_user_id);
            array_push($result['counts'], $count_contact_message);
        }

        echo json_encode($result);
        die;

    }

    public function countNewGroupMessage(Request $request){
        $input = json_decode($request->getContent(), true);
        $group_ids = $request->group_ids;
        $result = [];
        $result['counts'] = [];
        $result['group_ids'] = [];
        foreach ($group_ids as $group_id){
            $count_group_message = count(self::getNewMessageFromGroup($group_id));
            array_push($result['group_ids'], $group_id);
            array_push($result['counts'], $count_group_message);
        }

        echo json_encode($result);
        die;
    }

    static public function seenMessages (Request $request){
//        $input = json_decode($request->getContent(), true);
        $message_ids = $request->message_ids;
        foreach ($message_ids as $message_id) {
            $message = Message::where('id', $message_id);
            $query = ['is_new' => 0];
            $message->update($query);
        }
        echo json_encode($message_ids);
        die;

    }
}
