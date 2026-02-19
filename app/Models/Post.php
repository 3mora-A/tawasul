<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;  // Add this import for user() relation

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faculty',
        'content',
        'image_path',
        'video_path',
        'link_url',
    ];

    // Post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function hasVideo()
    {
        return !empty($this->video_path);
    }

    public function hasImage()
    {
        return !empty($this->image_path);
    }

    public function mediaType()
    {
        if ($this->hasImage()) return 'image';
        if ($this->hasVideo()) return 'video';
        if (!empty($this->link_url)) return 'link';
        return 'text';
    }

    // Add this scope method to filter posts by faculty
    public function scopeForFaculty($query, $faculty)
    {
        return $query->where('faculty', $faculty);
    }
    public function reports()
{
    return $this->hasMany(Report::class);
}

}
