<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function commentstore(CommentStoreRequest $request){
        $comment = new Comment();
        $comment->create([
            'user_id' => Auth::id(),
            'phone_id' => $request->phone_id,
            'comment' => $request->comment,
        ]);
        return $this->success(new CommentResource($comment),__('messages.commented'));
    }
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        if(Auth::id() !== $comment->user_id){
            return $this->error(__('messages.comment_notfound'));
        }
        $comment->delete();
        return $this->success(__('messages.comment_deleted'),204);
    }
}
