<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommunityPostController extends Controller
{
    /**
     * Store a new post in a community.
     */
    public function store(Request $request, Community $community)
    {
        $request->validate([
            'content' => 'required_without:media|string|max:1000',
            'media'   => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm,quicktime',
        ]);

        // Enforce size limits
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mime = $file->getMimeType();
            $size = $file->getSize();

            if (Str::startsWith($mime, 'image') && $size > 20 * 1024 * 1024) {
                return back()
                    ->withErrors(['media' => 'Image must not exceed 20MB.'])
                    ->withInput();
            }

            if (Str::startsWith($mime, 'video') && $size > 500 * 1024 * 1024) {
                return back()
                    ->withErrors(['media' => 'Video must not exceed 500MB.'])
                    ->withInput();
            }
        }

        // Create the post linked to this community
        $post = $community->posts()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        // Handle the uploaded file
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('community/post_media', 'public');

            if (Str::startsWith($file->getMimeType(), 'video')) {
                $post->video_path = $path;
            } else {
                $post->image_path = $path;
            }

            $post->save();
        }

        return back()->with('success', 'Post created successfully!');
    }

    /**
     * Delete a community post.
     */
    public function destroy(Community $community, CommunityPost $post)
    {
        // Make sure this post really belongs to the community
        if ($post->community_id !== $community->id) {
            abort(404);
        }

        // Only the author or community creator can delete
        if (Auth::id() !== $post->user_id && Auth::id() !== $community->creator_id) {
            abort(403);
        }

        // Delete media files if any
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path) {
            Storage::disk('public')->delete($post->video_path);
        }

        $post->delete();

        return back()->with('success', 'Post deleted!');
    }

    /**
     * Add a comment to a community post.
     */
    public function storeComment(Request $request, Community $community, CommunityPost $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Make sure post belongs to community
        if ($post->community_id !== $community->id) {
            abort(404);
        }

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Comment added!');
    }

    /**
     * Like a post.
     */
    public function like(Community $community, CommunityPost $post)
    {
        if (! $post->likes()->where('user_id', Auth::id())->exists()) {
            $post->likes()->create(['user_id' => Auth::id()]);
        }

        return response()->json([
            'liked' => true,
            'count' => $post->likes()->count(),
        ]);
    }

    /**
     * Unlike (remove a like).
     */
    public function unlike(Community $community, CommunityPost $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return response()->json([
            'liked' => false,
            'count' => $post->likes()->count(),
        ]);
    }
}
