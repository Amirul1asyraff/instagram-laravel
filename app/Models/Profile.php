<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'photo_profile',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
