<?php

namespace app\Http\Controllers;

use App\Models\comments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    public function store(Request $request,$id)
    {
        $request->validate([
            'comment'=>'required'
        ]);
        $user=Auth::user()->id;
        $comment = new comments();
        $comment->product()->associate($id);
        $comment->comment=$request->comment;
        $comment->user_id=$user;
        $comment->save();
       flash()->timeOut(1000)->success('Comment Added Successfully');
        return redirect()->back();
    }
}
