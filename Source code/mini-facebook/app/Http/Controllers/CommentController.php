<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addNewComment(Request $request){
        $input = json_decode($request->getContent(), true);
        $comment = Comment::create($input);
        $comment_count = count(Comment::where('post_id', $input['post_id'])->get());
        $current_user = Auth::user();
        echo json_encode(['current_user' => $current_user, 'comment'=>$comment, 'comment_count'=>$comment_count]);
        die;
    }

    public function deleteComment($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        echo json_encode($id);
        die;
    }

    public function getComment($id){
        $comment = Comment::findOrFail($id);
        echo json_encode($comment);
        die;
    }

    public function updateComment(Request $request, $id){
        $input = json_decode($request->getContent(), true);
        $comment = Comment::where('id', $id);
        $query = ['comment_content' => $input->comment_content];
        $comment->update($query);
        echo json_encode($comment);
        die;
    }

}
