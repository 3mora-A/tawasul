<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    $comment = $post->comments()->create([
        'user_id' => Auth::id(),
        'content' => $request->content
    ]);

    $user = $comment->user; // eager load user if not already

    return response()->json([
        'content' => $comment->content,
        'username' => $user->name ?? 'Unknown',
        'profile_picture' => $user->profile_image 
            ? asset('storage/' . $user->profile_image) 
            : asset('images/default.png'),
        'timestamp' => $comment->created_at->diffForHumans()
    ]);
}

public function destroy($id)
{
    $comment = Comment::findOrFail($id);

    if (auth()->id() !== $comment->user_id) {
        abort(403, 'Unauthorized action.');
    }

    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}


    
    
}
