<?php

namespace App\Models;

use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = "posts";
    protected $fillable = [
        'user_id',
        'photo_post',
        'caption',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
