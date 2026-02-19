<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use App\Models\CommunityPostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityPostCommentController extends Controller
{
    /**
     * Store a new comment under a community post.
     */
    public function store(Request $request, Community $community, CommunityPost $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Make sure this post belongs to the given community
        if ($post->community_id !== $community->id) {
            abort(404);
        }

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $user = $comment->user; // relation

        // Return JSON so your JS can append it without a full page reload
        return response()->json([
            'id'              => $comment->id,
            'content'         => $comment->content,
            'username'        => $user->username ?? 'Unknown',
            'profile_picture' => $user->profile_picture
                                   ? asset('storage/' . $user->profile_picture)
                                   : asset('images/default_profile.png'),
            'timestamp'       => $comment->created_at->diffForHumans(),
        ], 201);
    }

    /**
     * Delete an existing comment.
     */
 public function destroy(
    Community            $community,
    CommunityPost        $post,
    CommunityPostComment $comment
) {
    // 1. Post must belong to community
    abort_unless($post->community_id === $community->id, 404);

    // 2. Comment must belong to this post (use post_id)
    abort_unless($comment->post_id === $post->id, 404);

    // 3. Only the comment’s author can delete
    abort_unless($comment->user_id === Auth::id(), 403);

    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}

    
}
