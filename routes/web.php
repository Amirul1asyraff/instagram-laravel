<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/post', [PostController::class,'index'])->name('post.index');
Route::get('/post/create', [PostController::class,'create'])->name('post.create');
Route::post('/post', [PostController::class,'store'])->name('post.store');
Route::get('/post/{post}/edit', [PostController::class,'edit'])->name('post.edit');
Route::put('/post/{post}', action: [PostController::class,'update'])->name('post.update');
Route::delete('/post/{post}', [PostController::class,'destroy'])->name('post.destroy');
Route::get('/post/{post}', [PostController::class,'show'])->name('post.show');

// Comment routes
Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comment/{post}', [CommentController::class, 'destroy'])->name('comment.destroy');

//profile
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile.store');


