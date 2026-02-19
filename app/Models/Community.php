<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{


    protected $fillable = [
        'name', 'description', 'creator_id', 'banner_path', 'icon_path',
    ];


    
      
public function creator(){
    return $this->belongsTo(User::class,'creator_id');
}

public function members()
{
    return $this->belongsToMany(User::class, 'community_user', 'community_id', 'user_id')
                ->withTimestamps();
}

public function posts(){
    return $this->hasMany(CommunityPost::class);
}

}