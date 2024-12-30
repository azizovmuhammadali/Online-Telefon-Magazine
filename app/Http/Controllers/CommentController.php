<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function commentstore(CommentStoreRequest $request){
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::id();
        $comment->phone_id = $request->phone_id;
        $comment->save();
        return $this->success(new CommentResource($comment->load('user.images')),__('messages.commented'));
    }
    public function commentdestroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        if(Auth::id() !== $comment->user_id){
            return $this->error(__('messages.comment_notfound'));
        }
        $comment->delete();
        return $this->success(__('messages.comment_deleted'),204);
    }
}
