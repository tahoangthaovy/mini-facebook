<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Friend;
use App\Like;
use App\Message;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static function getCurrentUserFriends(){
        $current_user = Auth::user();
        $friends = Friend::where('user1', $current_user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        foreach ($friends as $friend){
            $friend['user_data'] = User::findOrFail($friend->user2);
            $friend['messages'] =
                Message::whereIn('sent_user', [$current_user->id, $friend->user2])
                    ->whereIn('received_user', [$current_user->id, $friend->user2])
                    ->orderBy('id', 'asc')
                    ->get();
            $friend['new_message_count'] = count(MessageController::getNewMessageFromContact($friend->user2));
            if($friend['new_message_count'] > 0){
                $friend['has_new_message'] = true;
            }
        }
        return $friends;
    }
    public function isFriend($id, $user){
        $friends = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        foreach ($friends as $friend){
            if($friend->user2 == $id)
                return true;
        }
        return false;
    }
    public function isRequest($id, $user){
        $friends = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.pending'))->get();
        foreach ($friends as $friend){
            if($friend->user2 == $id)
                return true;
        }
        return false;
    }
    public function getUserById($user_id){
        $current_user = Auth::user();
        $user = User::findOrFail($user_id);
        $user['is_friend'] = $this->isFriend($current_user->id, $user);
        $user['is_request'] = $this->isRequest($current_user->id, $user);
        $posts = Post::where('user_id', $user_id)->orderBy('id','desc')->take(10)->get();
        foreach ($posts as $post){
            $now_date = strtotime(date("Y-m-d H:i:s"));
            $post_updated = strtotime(date($post->updated_at));
            $post['date'] = PostController::humanizeDateDifference($now_date, $post_updated);
            $post['comments'] = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();
            $post['likes'] = Like::where('post_id', $post->id)->get();
            $post['is_liked'] = LikeController::isLike($post->id);
            foreach ($post['comments'] as $comment){
                $comment['comment_author'] = User::where('id', $comment->user_id)->first();
            }
            $author = User::where('id', $post->user_id)->first();
            $post['post_author'] = $author;
        }
        $current_user_friends = self::getCurrentUserFriends();
        $groups = GroupController::getCurrentUserGroups();
        $requests = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.pending'))->get();
        return view('dashboard.user.user-detail', compact('posts', 'current_user', 'user', 'current_user_friends', 'groups', 'requests'));
    }

    public function getFriendList($user_id){
        $current_user = Auth::user();
        $user = User::findOrFail($user_id);
        $user['is_friend'] = $this->isFriend($current_user->id, $user);
        $user['is_request'] = $this->isRequest($current_user->id, $user);
        $friends = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        $current_friends = Friend::where('user1', $current_user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        $friend_ids = [];
        $current_friend_ids = [];
        //get ids
        foreach ($friends as $friend){
            array_push($friend_ids, $friend->user2);
        }
        foreach ($current_friends as $current_friend){
            array_push($current_friend_ids, $current_friend->user2);
        }
//        dd($friend_ids);
//        dd($current_friend_ids);
        $mutual_friends = array_intersect($friend_ids, $current_friend_ids);
        foreach ($friends as $friend){
            //Check if is friend or is request
                //If visit self friend list, there is no mutual friends here
            if ($current_user->id == $user->id){
                $friend['is_mutual'] = false;
            }
            else {
                $friend['is_mutual'] = array_search($friend->user2, $mutual_friends);
            }
            $friend['user_data'] = User::findOrFail($friend->user2);
        }
        $current_user_friends = self::getCurrentUserFriends();
        $groups = GroupController::getCurrentUserGroups();
        $requests = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.pending'))->get();
        return view('dashboard.user.friend-list', compact('user', 'friends', 'current_user', 'current_user_friends', 'groups', 'requests'));
    }

    public function getFriendRequests($user_id){
        $current_user = Auth::user();
        $user = User::findOrFail($user_id);
        $user['is_friend'] = $this->isFriend($current_user->id, $user);
        $user['is_request'] = $this->isRequest($current_user->id, $user);
        $requests = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.pending'))->get();
        $friends = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        foreach ($requests as $request){
            $request['user_data'] = User::findOrFail($request->user2);
        }
        foreach ($friends as $friend){
            $friend['user_data'] = User::findOrFail($friend->user2);
        }
        $current_user_friends = self::getCurrentUserFriends();
        $groups = GroupController::getCurrentUserGroups();
        return view('dashboard.user.friend-request', compact('user', 'requests', 'current_user', 'friends', 'current_user_friends', 'groups'));
    }

    public function getAbout($user_id){
        $user = User::findOrFail($user_id);
        $current_user = Auth::user();
        $user['is_friend'] = $this->isFriend($current_user->id, $user);
        $user['is_request'] = $this->isRequest($current_user->id, $user);
        $friends = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.friend'))->get();
        foreach ($friends as $friend){
            $friend['user_data'] = User::findOrFail($friend->user2);
        }
        $current_user_friends = self::getCurrentUserFriends();
        $groups = GroupController::getCurrentUserGroups();
        $requests = Friend::where('user1', $user->id)->where('status' , config('dashboard.user.friend-list.status.pending'))->get();
        return view('dashboard.user.about', compact('user', 'friends', 'current_user_friends', 'current_user', 'groups', 'requests'));
    }

    public function getAvatarAndCover($user_id){
        $user = User::findOrFail($user_id);
        $current_user = Auth::user();
        $user['is_friend'] = $this->isFriend($current_user->id, $user);
        $user['is_request'] = $this->isRequest($current_user->id, $user);
        $current_user_friends = self::getCurrentUserFriends();
        $groups = GroupController::getCurrentUserGroups();
        return view('dashboard.user.change-cover-avatar', compact('user', 'current_user_friends', 'current_user', 'groups'));
    }

    public function removeFriendById($friend_id){
        $current_user = Auth::user();
        $friend_id = intval($friend_id);
        $friend1 = Friend::where('user1', $friend_id)->where('user2', $current_user->id);
        $friend1->delete();
        $friend2 = Friend::where('user1', $current_user->id)->where('user2', $friend_id);
        $friend2->delete();
        echo json_encode($friend_id);
        die;
    }

    public function acceptRequest($friend_id){
        $current_user = Auth::user();
        $friend_id = intval($friend_id);
        $friend1 = Friend::where('user1', $friend_id)->where('user2', $current_user->id);
        $temp1 = $friend1->get();
        if(count($temp1) == 0){
            $friend1 = new Friend();
            $friend1->user1 = $friend_id;
            $friend1->user2 = $current_user->id;
            $friend1->status = 2;
            $friend1->save();
        }
        else {
            $friend1->update(['status' => 2]);
        }

        $friend2 = Friend::where('user1', $current_user->id)->where('user2', $friend_id);
        $temp2 = $friend2->get();
        if(count($temp2) == 0){
            $friend2 = new Friend();
            $friend2->user2 = $friend_id;
            $friend2->user1 = $current_user->id;
            $friend2->status = 2;
            $friend2->save();
        }
        else {
            $friend2->update(['status' => 2]);
        }

        echo json_encode($friend_id);
        die;
    }

    public function addFriend($friend_id){
        $current_user = Auth::user();
        $friend_id = intval($friend_id);
        $friend1 = Friend::where('user2', $current_user->id)->where('user1', $friend_id)->get();
        if (count($friend1) == 0){
            $friend1 = new Friend();
            $friend1->user2 = $current_user->id;
            $friend1->user1 = $friend_id;
            $friend1->status = 1;
            $friend1->save();
        }

        echo json_encode($friend_id);
        die;
    }

    public function updateAbout(Request $request){
        $input = $request->all();
        $user = User::where('id', Auth::user()->id);
        $user->update(['about' => $input['about']]);
        return redirect()->back();
    }

    public function updateAvatar(Request $request){
        $current_user = Auth::user();
        $user = User::where('id', $current_user->id);
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            $path = public_path(). '/img/avatars/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);

            $input['avatar'] = '/img/avatars/' .  $filename;
        }

        $user->update(['avatar' => $input['avatar']]);

        //Add new post
        $post_data = [];
        $post_data['image_path'] = $input['avatar'];
        $post_data['user_id'] = $current_user->id;
        $post_data['post_content'] = "I have just update new avatar.";
        Post::create($post_data);

        return redirect()->back();
    }

    public function updateCover(Request $request){
        $current_user = Auth::user();
        $user = User::where('id', $current_user->id);
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            $path = public_path(). '/img/covers/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);

            $input['cover'] = '/img/covers/' .  $filename;
        }

        $user->update(['cover' => $input['cover']]);

        //Add new post
        $post_data = [];
        $post_data['image_path'] = $input['cover'];
        $post_data['user_id'] = $current_user->id;
        $post_data['post_content'] = "I have just update new cover photo.";
        Post::create($post_data);

        return redirect()->back();
    }

}
