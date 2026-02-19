<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
//     public function index()
// {
//     return view('search.index');
// }

public function index()
    {
        return view('search.index', [
            'title' => 'Search'
        ]);
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));
        
        // Minimum 2 characters to search
        if (strlen($query) < 2) {
            return response()->json([
                'users' => [],
                'communities' => []
            ]);
        }

        $results = [
            'users' => [],
            'communities' => []
        ];

        // Search users (when @ prefix or general search)
        if (!str_starts_with($query, '#')) {
            $userSearchTerm = str_starts_with($query, '@') ? substr($query, 1) : $query;
            
            $results['users'] = User::where(function($q) use ($userSearchTerm) {
                    $q->where('username', 'like', "%{$userSearchTerm}%")
                      ->orWhere('name', 'like', "%{$userSearchTerm}%");
                })
                ->whereNotNull('username')
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    // Fix: Remove all @ symbols first, then add one
                    $cleanUsername = str_replace('@', '', $user->username);
                    return [
                        'id' => $user->id,
                        'type' => 'user',
                        'username' => '@'.$cleanUsername,
                        'name' => $user->name,
                        'avatar' => $user->profile_picture 
                            ? Storage::url($user->profile_picture)
                            : asset('images/default-avatar.png')
                    ];
                });
        }

        // Search communities (when # prefix or general search)
        if (!str_starts_with($query, '@')) {
            $communitySearchTerm = str_starts_with($query, '#') ? substr($query, 1) : $query;
            
            $results['communities'] = Community::where('name', 'like', "%{$communitySearchTerm}%")
                ->withCount('members')
                ->limit(5)
                ->get()
                ->map(function ($community) {
                    return [
                        'id' => $community->id,
                        'type' => 'community',
                        'name' => $community->name,
                        'description' => $community->description,
                        'faculty' => $community->faculty,
                        'image' => $community->image_path 
                            ? Storage::url($community->image_path)
                            : asset('images/default-community.png'),
                        'members_count' => $community->members_count,
                        'creator_id' => $community->creator_id,
                        'slug' => $community->slug // Added missing slug field
                    ];
                });
        }

        return response()->json($results);
    }
}
