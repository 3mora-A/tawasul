<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function show($id)
    {
        $user = User::findOrFail($id);
    
        $isFollowing = false;
        if (auth()->check() && auth()->id() !== $user->id) {
            $isFollowing = auth()->user()->isFollowing($user);
        }
    
        return view('profile-mine-public', compact('user', 'isFollowing'));
    }
    



}
