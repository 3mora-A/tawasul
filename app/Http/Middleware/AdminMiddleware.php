<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        // 1. Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $user = auth()->user();
        
        // 2. Check if user is admin (role_id = 0)
        if ($user->role_id === 0) {
            return $next($request);
        }

        // 3. Log rejection details (now with proper Log import)
        Log::warning('Admin access denied', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'attempted_route' => $request->path()
        ]);

        return redirect('/')->with('error', 'Admin access only');
    }
}
