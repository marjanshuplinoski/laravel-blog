<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comments();
        $comment->from_user = $request->user()->id;
        $comment->on_post = $request->on_post;
        $comment->body = $request->body;
        $slug = $request->slug;
        $comment->save();
        return redirect($slug)->with("message","Comment published");
    }

}
