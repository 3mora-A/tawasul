<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuggestedUserController extends Controller
{
    public function index()
    {
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        return view('suggested-users', compact('suggestedUsers'));
    }
}
