<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $comments = Comment::where("post_id", $post->id)->get();
        return view('post.show', compact('post','comments'));
    }
    public function create()
    {
        return view("post.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'photo_post' => 'required|image|max:2048', // Adjust max size as needed
            'caption' => 'required|string|max:500',    // Adjust max length as needed
        ]);

        $user = auth()->user();
        $fileName = $user->name . '_' . now()->format('Ymd_His') . '.' . $request->file('photo_post')->getClientOriginalExtension();
        $imagePath = $request->file('photo_post')->storeAs('posts', $fileName, 'public');

        $post = Post::create([
            'user_id' => $user->id,
            'photo_post' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }


    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'caption' => 'required',
        ]);

        $post->update([
            'caption' => $request->caption,
        ]);
        return redirect()->route('home');
    }
    public function destroy(Post $post)
    {
        // Delete related comments first
        $post->comments()->delete();

        // Then delete the post
        $post->delete();
        return back();
    }

    
}
