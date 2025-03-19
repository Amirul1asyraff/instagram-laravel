<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Use eager loading to prevent N+1 query issues
        $posts = Post::with('User')->latest()->paginate(10);

        // Get users with post count for the sidebar - withCount efficiently adds a posts_count attribute
        $users = User::withCount('posts')->orderBy('posts_count', 'desc')->get();

        // Pass data to view
        return view('home', compact('posts', 'users'));
    }
}
