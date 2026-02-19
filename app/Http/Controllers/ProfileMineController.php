<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileMineController extends Controller
{
    /**
     * Load sidebar data for any profile view.
     */
    protected function loadSidebarData(User $user): array
    {
        return [
            'user'           => $user,
            'suggestedUsers' => User::where('id', '!=', $user->id)
                                    ->inRandomOrder()
                                    ->take(5)
                                    ->get(),
            'followers'      => $user->followers()
                                    ->select('users.id','users.username','users.profile_picture')
                                    ->get(),
            'following'      => $user->following()
                                    ->select('users.id','users.username','users.profile_picture')
                                    ->get(),
        ];
    }

    /*------------------------------------------------------
     | Private (own) profile tabs
     -----------------------------------------------------*/

    public function showProfile()
    {
        $user    = Auth::user();
        $sidebar = $this->loadSidebarData($user);

        return view('profile-mine', array_merge($sidebar, [
            'activeTab' => 'details',
        ]));
    }

    public function showFollowers()
    {
        $user    = Auth::user();
        $sidebar = $this->loadSidebarData($user);

        return view('profile-mine', array_merge($sidebar, [
            'activeTab' => 'followers',
        ]));
    }

    public function showFollowing()
    {
        $user    = Auth::user();
        $sidebar = $this->loadSidebarData($user);

        return view('profile-mine', array_merge($sidebar, [
            'activeTab' => 'following',
        ]));
    }

    public function showPosts()
    {
        $user    = Auth::user();
        $sidebar = $this->loadSidebarData($user);
    
        // 1. Your own public feed posts
        $feedPosts = Post::with(['user','comments.user','likes'])
                         ->where('user_id', $user->id)
                         ->whereNull('faculty')
                         ->latest()
                         ->get();
    
        // 2. Your own faculty‐tagged posts
        $facultyPosts = Post::with(['user','comments.user','likes'])
                            ->where('user_id', $user->id)
                            ->whereNotNull('faculty')
                            ->latest()
                            ->get();
    
        // 3. YOUR community posts only
        $communityIds = $user->communities->pluck('id');
        $communityPosts = CommunityPost::with(['user','comments.user','likes'])
                                      ->whereIn('community_id', $communityIds)
                                      ->where('user_id', $user->id)   // ← only your posts
                                      ->latest()
                                      ->get();
    
        return view('profile-mine', array_merge($sidebar, [
            'activeTab'      => 'posts',
            'feedPosts'      => $feedPosts,
            'facultyPosts'   => $facultyPosts,
            'communityPosts' => $communityPosts,
        ]));
    }
    


    public function showSettings()
    {
        $user    = Auth::user();
        $sidebar = $this->loadSidebarData($user);

        return view('profile-mine', array_merge($sidebar, [
            'activeTab' => 'settings',
        ]));
    }

    /*------------------------------------------------------
     | Public profile (any user)
     -----------------------------------------------------*/

    public function showPublicProfile(User $user)
    {
        $sidebar = $this->loadSidebarData($user);

        $isOwnProfile = Auth::check() && Auth::id() === $user->id;
        $isFollowing  = Auth::check() && ! $isOwnProfile && Auth::user()->isFollowing($user);

        $feedPosts     = Post::with(['user','comments.user','likes'])
                             ->where('user_id', $user->id)
                             ->whereNull('faculty')
                             ->latest()
                             ->get();
        $facultyPosts  = Post::with(['user','comments.user','likes'])
                             ->where('user_id', $user->id)
                             ->whereNotNull('faculty')
                             ->latest()
                             ->get();
        $communityIds   = $user->communities->pluck('id');
        $communityPosts = CommunityPost::with(['user','comments.user','likes'])
                             ->whereIn('community_id', $communityIds)
                             ->latest()
                             ->get();

        return view('profile-mine-public', array_merge($sidebar, [
            'activeTab'      => 'details',
            'isOwnProfile'   => $isOwnProfile,
            'isFollowing'    => $isFollowing,
            'feedPosts'      => $feedPosts,
            'facultyPosts'   => $facultyPosts,
            'communityPosts' => $communityPosts,
        ]));
    }
            /**
         * Show followers tab on public profile.
         */
        public function showPublicFollowers(User $user)
        {
            return view('profile-mine-public', array_merge(
                $this->loadSidebarData($user),
                [
                    'activeTab'      => 'followers',
                    'isOwnProfile'   => Auth::check() && Auth::id() === $user->id,
                    'isFollowing'    => Auth::check() && ! (Auth::id() === $user->id) && Auth::user()->isFollowing($user),
                    'feedPosts'      => [], 'facultyPosts' => [], 'communityPosts' => [],
                ]
            ));
        }

        /**
         * Show following tab on public profile.
         */
        public function showPublicFollowing(User $user)
        {
            return view('profile-mine-public', array_merge(
                $this->loadSidebarData($user),
                [
                    'activeTab'      => 'following',
                    'isOwnProfile'   => Auth::check() && Auth::id() === $user->id,
                    'isFollowing'    => Auth::check() && ! (Auth::id() === $user->id) && Auth::user()->isFollowing($user),
                    'feedPosts'      => [], 'facultyPosts' => [], 'communityPosts' => [],
                ]
            ));
        }

        /**
         * Show posts tab on public profile.
         */
        public function showPublicPosts(User $user)
        {
            $sidebar = $this->loadSidebarData($user);
        
            $feedPosts = Post::with(['user','comments.user','likes'])
                             ->where('user_id', $user->id)
                             ->whereNull('faculty')
                             ->latest()
                             ->get();
        
            $facultyPosts = Post::with(['user','comments.user','likes'])
                                ->where('user_id', $user->id)
                                ->whereNotNull('faculty')
                                ->latest()
                                ->get();
        
            $communityIds = $user->communities->pluck('id');
        
            $communityPosts = CommunityPost::with(['user','comments.user','likes'])
                                          ->whereIn('community_id', $communityIds)
                                          ->where('user_id',        $user->id)  // ← only this user’s community posts
                                          ->latest()
                                          ->get();
        
            return view('profile-mine-public', array_merge($sidebar, [
                'activeTab'      => 'posts',
                'isOwnProfile'   => Auth::check() && Auth::id() === $user->id,
                'isFollowing'    => Auth::check() && ! (Auth::id() === $user->id) && Auth::user()->isFollowing($user),
                'feedPosts'      => $feedPosts,
                'facultyPosts'   => $facultyPosts,
                'communityPosts' => $communityPosts,
            ]));
        }
        

        


    /*------------------------------------------------------
     | Profile updates (own only)
     -----------------------------------------------------*/

    public function updateInformation(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'faculty'    => 'nullable|string|max:255',
            'major'      => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'bio'        => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->username   = $data['name'];
        $user->faculty    = $data['faculty'];
        $user->major      = $data['major'];
        $user->university = $data['university'];
        $user->bio        = $data['bio'];
        $user->save();

        return response()->json(['success' => true, 'message' => 'Profile updated']);
    }

    public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:102400',
    ]);

    $user = Auth::user();

    if ($request->hasFile('profile_picture')) {
        // Only delete if there’s something to delete
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $user->profile_picture = $path;
        $user->save();
    }

    return back()->with('success', 'Profile picture updated');
}

public function updateCover(Request $request)
{
    $request->validate([
        'cover_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:512000',
    ]);

    $user = Auth::user();

    if ($request->hasFile('cover_picture')) {
        // Only delete if there’s something to delete
        if ($user->cover_picture && Storage::disk('public')->exists($user->cover_picture)) {
            Storage::disk('public')->delete($user->cover_picture);
        }

        $path = $request->file('cover_picture')->store('covers', 'public');
        $user->cover_picture = $path;
        $user->save();
    }

    return back()->with('success', 'Cover photo updated');
}


    /**
     * Delete user account and associated media.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
    
        // 1. Delete profile picture
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }
    
        // 2. Delete cover picture
        if ($user->cover_picture && Storage::disk('public')->exists($user->cover_picture)) {
            Storage::disk('public')->delete($user->cover_picture);
        }
    
        // 3. Ensure posts and communityPosts are loaded
        $user->loadMissing('posts', 'communityPosts');
    
        // 4. Delete media from normal posts
        foreach ($user->posts ?? [] as $post) {
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            if ($post->video_path && Storage::disk('public')->exists($post->video_path)) {
                Storage::disk('public')->delete($post->video_path);
            }
            $post->delete();
        }
    
        // 5. Delete media from community posts
        foreach ($user->communityPosts ?? [] as $post) {
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            if ($post->video_path && Storage::disk('public')->exists($post->video_path)) {
                Storage::disk('public')->delete($post->video_path);
            }
            $post->delete();
        }
    
        // 6. Remove entire community banners & icons folders
        if (Storage::disk('public')->exists('community_banners')) {
            Storage::disk('public')->deleteDirectory('community_banners');
        }
        if (Storage::disk('public')->exists('community_icons')) {
            Storage::disk('public')->deleteDirectory('community_icons');
        }
    
        // 7. Log out and delete user
        Auth::logout();
        $user->delete();
    
        return redirect()->route('home-page')
                         ->with('status', 'Your account and all your media have been deleted successfully.');
    }
    
}
