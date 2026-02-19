<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('role_id', '!=', 0)->get();
        return view('admin.users', compact('users'));
    }

  

public function deleteUser(User $user)
{
    // Delete profile picture
    if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
        Storage::disk('public')->delete($user->profile_picture);
    }

    // Delete cover picture
    if ($user->cover_picture && Storage::disk('public')->exists($user->cover_picture)) {
        Storage::disk('public')->delete($user->cover_picture);
    }

    // Load posts, communityPosts, and created/joined communities
    $user->loadMissing(['posts', 'communityPosts', 'createdCommunities', 'communities']);

    // Delete media from normal posts
    foreach ($user->posts as $post) {
        if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path && Storage::disk('public')->exists($post->video_path)) {
            Storage::disk('public')->delete($post->video_path);
        }
        $post->delete();
    }

    // Delete media from community posts
    foreach ($user->communityPosts as $post) {
        if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path && Storage::disk('public')->exists($post->video_path)) {
            Storage::disk('public')->delete($post->video_path);
        }
        $post->delete();
    }

    // Detach from communities the user has joined (don't delete them)
    $user->communities()->detach();

    // Handle communities created by the user
    foreach ($user->createdCommunities as $community) {
        // Option 1: Set creator_id to null
        $community->creator_id = null;
        $community->save();

        // Option 2: Or transfer to another admin
        // $community->creator_id = 1;
        // $community->save();
    }

    // Finally, delete the user
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'User and related data deleted successfully. Communities preserved.');
}




    
    public function reports()
    {
        $reports = Report::with(['reporter', 'post', 'communityPost.community', 'communityPost.user'])->latest()->paginate(10);
        return view('admin.reports', compact('reports'));
    }

    public function destroyReport(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports')->with('success', 'Report deleted successfully.');
    }

    public function deletePost(Post $post)
    {
        // Delete media files if exist
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path) {
            Storage::disk('public')->delete($post->video_path);
        }

        $post->delete();
        return redirect()->route('admin.reports')->with('success', 'Post deleted successfully.');
    }

    public function deleteCommunityPost(CommunityPost $post)
    {
        // Delete media files if exist
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path) {
            Storage::disk('public')->delete($post->video_path);
        }

        $post->delete();
        return redirect()->route('admin.reports')->with('success', 'Post deleted successfully.');
    }

    public function communities()
    {
        $communities = Community::latest()->paginate(10);
        return view('admin.communities', compact('communities'));
    }



    public function deleteCommunity(Community $community)
{
    // 1) Delete banner & icon files if they exist
    if ($community->banner_path) {
        Storage::disk('public')->delete($community->banner_path);
    }

    if ($community->icon_path) {
        Storage::disk('public')->delete($community->icon_path);
    }

    // 2) Delete all community posts and their media
    $posts = $community->posts()->get();

    foreach ($posts as $post) {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        if ($post->video_path) {
            Storage::disk('public')->delete($post->video_path);
        }

        $post->delete();
    }

    // 3) Delete the community record itself
    $community->delete();

    // 4) Redirect back with success
    return redirect()->route('admin.communities')->with('success', 'Community and all its posts were deleted successfully.');
}

public function dashboard()
{
    return view('admin.home');
}

}