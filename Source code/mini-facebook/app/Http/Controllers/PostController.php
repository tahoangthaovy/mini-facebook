<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Friend;
use App\Like;
use App\Post;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (isset($_GET['q'])) {
            $search = $_GET['q'];
            $current_user = Auth::user();
            $current_user_friends = UserController::getCurrentUserFriends();
            $groups = GroupController::getCurrentUserGroups();
            $users = User::where('name', 'LIKE', '%'.$search.'%')->get();
            return view('dashboard.search-result', compact('users', 'current_user', 'current_user_friends', 'groups'));
        }
        $current_user = Auth::user();
        $current_user_friends = UserController::getCurrentUserFriends();
        $friend_ids = [$current_user->id];
        foreach ($current_user_friends as $current_user_friend){
            array_push($friend_ids, $current_user_friend->user_data->id);
        }
        $posts = Post::whereIn('user_id', $friend_ids)->orderBy('id','desc')->take(10)->get();
        foreach ($posts as $post){
            $now_date = strtotime(date("Y-m-d H:i:s"));
            $post_updated = strtotime(date($post->updated_at));
            $post['date'] = self::humanizeDateDifference($now_date, $post_updated);
            $post['comments'] = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();
            $post['likes'] = Like::where('post_id', $post->id)->get();
            $post['is_liked'] = LikeController::isLike($post->id);
            foreach ($post['comments'] as $comment){
                $comment['comment_author'] = User::where('id', $comment->user_id)->first();
            }
            $author = User::where('id', $post->user_id)->first();
            $post['post_author'] = $author;
        }
        $groups = GroupController::getCurrentUserGroups();
        return view('dashboard.home', compact('posts', 'current_user', 'current_user_friends', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //to store post_content, use: real_escape_string();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            $path = public_path(). '/img/posts/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);

            $input['image_path'] = '/img/posts/' .  $filename;
        }
        unset($input['post_id']);
        Post::create($input);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            $path = public_path(). '/img/posts/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);

            $input['image_path'] = '/img/posts/' .  $filename;
        }
        else {
            $post = Post::findOrFail($id);
            $input['image_path'] = $post->image_path;
        }

        $post = Post::where('id', $id);
        $post->update($input);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id);

        $post->delete();
        $comments->delete();

        return redirect()->back();
    }

    public function getPostById($post_id){
        $post = Post::findOrFail($post_id);

        echo json_encode($post);
        die;
    }

    public function updateContent(Request $request){
        $input = json_decode($request->getContent(), true);

        $post = Post::where('id', $input['post_id']);
        $post->update(['post_content' => $input['post_content']]);
        $post = $post->first();
        echo json_encode($post);
        die;
    }

    public static function humanizeDateDifference($now,$otherDate){
        $offset = $now - $otherDate;
        $deltaS = $offset%60;
        $offset /= 60;
        $deltaM = $offset%60;
        $offset /= 60;
        $deltaH = $offset%24;
        $offset /= 24;
        $deltaD = ($offset > 1)?ceil($offset):$offset;
        if($deltaD > 1){
            if($deltaD > 365){
                $years = ceil($deltaD/365);
                if($years ==1){
                    return "last year";
                } else{
                    return "<br>$years years ago";
                }
            }
            if($deltaD > 6){
                return date('d-M',strtotime("$deltaD days ago"));
            }
            return "$deltaD days ago";
        }
        if($deltaD == 1){
            return "Yesterday";
        }
        if($deltaH == 1){
            return "last hour";
        }
        if($deltaM == 1){
            return "last minute";
        }
        if($deltaH > 0){
            return $deltaH." hours ago";
        }
        if($deltaM > 0){
            return $deltaM." minutes ago";
        }
        else{
            return "few seconds ago";
        }
    }

}
