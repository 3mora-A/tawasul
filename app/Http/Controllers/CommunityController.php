<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CommunityController extends Controller
{
    public function index(Request $request)
    {
        // Bypass any potential auth/relationship issues
        $user = \App\Models\User::with('communities')->find(Auth::id());
        
        // Nuclear fallback if relationship fails
        if (!method_exists($user, 'communities')) {
            $user->communities = function() use ($user) {
                return Community::whereIn('id', 
                    DB::table('community_user')
                      ->where('user_id', $user->id)
                      ->pluck('community_id')
                );
            };
        }
    
        $search = $request->input('search', ''); // Default empty if null
        
        // User's communities with search
        $userCommunities = $user->communities()
            ->when($search, function($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->withCount('members')
            ->paginate(10);
    
        // Suggested communities with search
        $suggestedCommunities = Community::query()
            ->whereDoesntHave('members', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->withCount('members')
            ->orderBy('members_count', 'desc')
            ->paginate(10);
    
        return view('communities.index', [
            'userCommunities' => $userCommunities,
            'suggestedCommunities' => $suggestedCommunities,
            'search' => $search
        ]);
    }


        public function create()
        {
            return view('communities.create');  // will use @extends('layouts.app') inside create.blade.php
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name'         => 'required|string|max:100|unique:communities',
                'description'  => 'nullable|string|max:500',
                'banner_path'  => 'nullable|image|max:102400',
                'icon_path'    => 'nullable|image|max:102400',
            ]);
        
            $community = Community::create([
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? '',
                'creator_id'  => Auth::id(),
            ]);
        
            // Banner
            if ($request->hasFile('banner_path')) {
                $path = $request->file('banner_path')
                                ->store('community_banners','public');
                $community->update(['banner_path' => $path]);
            }
        
            // Icon
            if ($request->hasFile('icon_path')) {
                $path = $request->file('icon_path')
                                ->store('community_icons','public');
                $community->update(['icon_path' => $path]);
            }
        
            $community->members()->attach(Auth::id());
        
            return redirect()
                ->route('communities.show',$community)
                ->with('success','Community created!');
        }
        


        public function join(Community $community){
            if (!$community->members()->where('user_id', Auth::id())->exists()) {
                $community->members()->attach(Auth::id());
                return back()->with('success', 'You have joined the community!');
        }

        }

        public function leave(Community $community)
        {
            $community->members()->detach(Auth::id());
            return back()->with('success', 'You have left the community.');
        }

        public function show(Community $community, Request $request)
        {
            // 1) Load counts
            $community->loadCount(['members','posts']);
        
            // 2) Eager-load creator (so we can do $community->creator->name)
            $community->load('creator');
        
            // 3) Sort & paginate posts
            $sortMethod = $request->input('sort','newest');
            $posts = $community->posts()
                ->with(['user','likes','comments'])
                ->withCount(['likes','comments'])
                ->when($sortMethod==='top', fn($q)=> $q->orderBy('likes_count','desc'), fn($q)=> $q->latest())
                ->paginate(10)
                ->appends(['sort'=>$sortMethod]);
        
            return view('communities.show', compact('community','posts','sortMethod'));
        }
        

        public function edit(Community $community){
            
                // Check if user is logged in
            if (!Auth::check()) {
                abort(403, 'You must be logged in to edit a community.');
            }

            // Check if the authenticated user is the creator
            if (Auth::id() !== $community->creator_id) {
                abort(403, 'Unauthorized action. Only the community creator can edit.');
            }

         return view('communities.edit', compact('community'));
        }



        public function update(Request $request, Community $community)
        {
            // 1) Validate—with unique rule ignoring current community
            $validated = $request->validate([
                'name'         => 'required|string|max:100|unique:communities,name,' . $community->id,
                'description'  => 'nullable|string|max:500',
                'banner_path'  => 'nullable|image|max:102400',
                'icon_path'    => 'nullable|image|max:102400',
            ]);

            // 2) Update basic fields
            $community->update([
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? '',
            ]);

            // 3) Handle new banner upload if present
            if ($request->hasFile('banner_path')) {
                // Optionally: delete old banner file here
                $path = $request->file('banner_path')
                                ->store('community_banners','public');
                $community->update(['banner_path' => $path]);
            }

            // 4) Handle new icon upload if present
            if ($request->hasFile('icon_path')) {
                // Optionally: delete old icon file here
                $path = $request->file('icon_path')
                                ->store('community_icons','public');
                $community->update(['icon_path' => $path]);
            }

            // 5) Redirect back to the community page
            return redirect()
                ->route('communities.show', $community)
                ->with('success', 'Community updated successfully!');
        }

     
        public function destroy(Community $community)
        {
            // 1) Authorization
            if (auth()->id() !== $community->creator_id) {
                abort(403, 'Unauthorized action.');
            }
        
            // 2) Delete community banner & icon
            if ($community->banner_path) {
                Storage::disk('public')->delete($community->banner_path);
            }
            if ($community->icon_path) {
                Storage::disk('public')->delete($community->icon_path);
            }
        
            // 3) Delete all posts & their media in this community
            //    First fetch all posts for this community
            $posts = $community->posts()->get();
        
            foreach ($posts as $post) {
                // If your posts table has an `image_path` column:
                if ($post->image_path) {
                    Storage::disk('public')->delete($post->image_path);
                }
                // If you also store video paths:
                if ($post->video_path) {
                    Storage::disk('public')->delete($post->video_path);
                }
        
                // Finally remove the post record
                $post->delete();
            }
        
            // 4) Delete the community record itself
            $community->delete();
        
            // 5) Redirect back with a success message
            return redirect()
                ->route('communities.index')
                ->with('status', 'Community and all its posts have been deleted.');
        }

}

    


