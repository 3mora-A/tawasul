<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    
    public function store(Post $post)
    {
        if (!$post->likedBy(Auth::user())) {
            $post->likes()->create(['user_id' => Auth::id()]);
            $post->increment('likes_count');
        }
    
        return response()->json([
            'liked' => true,
            'count' => $post->likes()->count(),
        ]);
    }
    
    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();
        $post->decrement('likes_count');
    
        return response()->json([
            'liked' => false,
            'count' => $post->likes()->count(),
        ]);
    }
    


}
