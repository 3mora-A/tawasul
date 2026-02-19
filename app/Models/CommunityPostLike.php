<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommunityPost;
use App\Models\User;

class CommunityPostLike extends Model
{
    // If your table is named community_post_likes, you can omit this:
    // protected $table = 'community_post_likes';

    // Use the community_post_id column here
    protected $fillable = ['community_post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
