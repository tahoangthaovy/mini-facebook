<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addNewLike(Request $request){
        $input = json_decode($request->getContent(), true);
        $input['user_id'] = Auth::user()->id;
        $like = Like::create($input);
        $like_count = count(Like::where('post_id', $input['post_id'])->get());
        echo json_encode(['like_count' => $like_count, 'like' => $like]);
        die;
    }

    public function deleteLike(Request $request){
        $input = json_decode($request->getContent(), true);
        $like = Like::where('user_id', Auth::user()->id)->where('post_id', $input['post_id']);
        $like->delete();
        $like_count = count(Like::where('post_id', $input['post_id'])->get());
        echo json_encode(['like_count' => $like_count]);
        die;

    }

    public static function isLike($post_id){
        $likes = Like::where('user_id', Auth::user()->id)->where('post_id', $post_id)->get();
        if (count($likes) > 0)
            return true;
        return false;
    }
}
