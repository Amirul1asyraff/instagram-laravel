<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'text' => 'required',
    ]);

    Comment::create([
        'user_id' => auth()->user()->id,
        'text' => $request->text,
        'post_id' => $post->id,
    ]);

    return redirect()->route('post.show', $post);
}

}
