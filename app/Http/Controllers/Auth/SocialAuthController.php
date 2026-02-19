<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}



    /**
     * Handle the Google OAuth callback for login or registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Retrieve user data from Google
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error('Google login failed: ' . $e->getMessage());

            return redirect()->route('login')->withErrors([
                'google_login' => 'Something went wrong during Google authentication. Please try again.',
            ]);
        }

        $email = $googleUser->getEmail();
        $user = User::where('email', $email)->first();

        // If the user doesn't exist, register them
        if (!$user) {
            $googleUserData = $googleUser->getRaw();
            $firstName = $googleUserData['given_name'] ?? '';
            $lastName = $googleUserData['family_name'] ?? '';

            // Generate a base username
            $baseUsername = strtolower(trim($firstName . ' ' . $lastName));
            $username = $baseUsername;
            $counter = 1;

            // Ensure the username is unique
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . ' ' . $counter;
                $counter++;
            }

            // Create the new user with a default secure password
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $email,
                'password' => bcrypt(Str::random(12)), // Random secure password
                'google_id' => $googleUser->getId(),
                'username' => $username,
            ]);

            // Log the user in after registration
            Auth::login($user);

            return redirect()->route('login')->with('status', 'Account successfully created and you are logged in with Google.');
        }

        // If the user exists, log them in
        Auth::login($user);

        return redirect()->route('posts-mine')->with('status', 'You are logged in using your Google account.');
    }

    /**
     * Handle password reset request for Google users (separate from login/registration).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleRequest(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        // Check if the user exists and was registered via Google (i.e., no password set)
        if ($user && $user->google_id) {
            // Generate a password reset token
            $token = Str::random(64);

            // Create or update the password reset record
            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );

            // Create the reset link
            $resetLink = url('/reset-password-form/' . $token . '?email=' . urlencode($user->email));

            // Send the reset link via email
            Mail::raw('Hi ' . $user->username . ", use this link to set your password: " . $resetLink, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Set Your Password (Google Login)');
            });

            return redirect()->route('login')->with('status', 'A password reset link has been sent to your email.');
        }

        // If the user does not exist or was not registered via Google
        return redirect()->route('login')->withErrors(['email' => 'No Google account found with that email.']);
    }
}
