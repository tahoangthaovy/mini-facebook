<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public static function getCurrentUserGroups(){
        $current_user = Auth::user();
        $results = [];
        $groups = Group::all();
        foreach ($groups as $group){
            $user_ids = json_decode($group->user_ids);
            foreach ($user_ids as $user_id){

                if ($current_user->id == $user_id){
                    $group['users'] = self::getUsersByGroup($group->id);
                    $group['messages'] = MessageController::getGroupMessages($group->id);
                    $group['new_message_count'] = count(MessageController::getNewMessageFromGroup($group->id));
                    if($group['new_message_count'] > 0){
                        $group['has_new_message'] = true;
                    }

                    array_push($results, $group);
                }
            }
        }

        return $results;
    }

    public static function getUsersByGroup($id){
        $group = Group::findOrFail($id);
        $user_ids = json_decode($group->user_ids);
        $users = [];
        foreach ($user_ids as $user_id){
            array_push($users, User::findOrFail($user_id));
        }
        return $users;

    }


    public function addNewGroup(Request $request){
        $current_user = Auth::user();
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            $path = public_path(). '/img/groups/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);

            $input['group_avatar'] = '/img/groups/' .  $filename;
        }
        else {
            $input['group_avatar'] = '/img/groups/group-no-image.png';
        }

        foreach ($input['users'] as $key => $value){
            $input['users'][$key] = (int)$value;
        }

        array_push($input['users'], $current_user->id);

        $input['user_ids'] = json_encode($input['users']);
        Group::create($input);

        return redirect()->back();
    }

    public function deleteGroup($group_id){
        $group = Group::where('id', $group_id);
        $group->delete();
        echo json_encode($group_id);
        die;
    }
}
