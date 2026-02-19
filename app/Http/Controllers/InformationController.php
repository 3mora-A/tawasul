<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Import Facade here correctly
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class InformationController extends Controller
{
    // Handle login form submission
    
// Handle login form submission


    public function handleLogin(Request $request)
    {
        // Validate email and password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();

            // Generate token (requires Laravel Sanctum or Passport)
            // Here assuming Sanctum is installed and set up
            $token = $user->createToken('auth_token')->plainTextToken;

            // Save token in session if you want to access it later (optional)
            $request->session()->put('user_token', $token);

            // Redirect to profile-mine with status message
            return redirect()->route('posts-mine')->with('status', 'You are logged in.');
        }

        // Login failed
        return redirect()->route('login')->with('error', 'Invalid email or password.')->withInput();
    }




public function handleRegister(Request $request)
{
    // 1) Validate including username uniqueness
    $request->validate([
        'username' => ['required','string','max:30','unique:users,username'],
        'email'    => ['required','email','unique:users,email'],
        'password' => [
            'required','confirmed','min:8',
            'regex:/^[^\s]*$/',    // no spaces
            'regex:/[A-Z]/',       // at least one uppercase
            'regex:/[@$]/',        // at least one special char (@ or $)
        ],
        'faculty'  => ['required','string'],
    ], [
        'username.unique' => 'This username is already taken. Please choose another.',
        'password.regex'  => 'Password must have no spaces, one uppercase letter, and one special char (@ or $).',
    ]);

    // 2) Use exactly what the user entered
    $username = trim($request->username);

    // 3) Create the user
    User::create([
        'username' => $username,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'faculty'  => $request->faculty,
    ]);

    // 4) Redirect
    return redirect()
        ->route('login')
        ->with('status', 'Account created successfully. You may now login.');
}


        

    // Handle forgot password request
    public function handleResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            // Generate a token
            $token = Str::random(64);
    
            // Store the token in the password_resets table
            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );
    
            // Send reset email
            $resetLink = url('/reset-password-form/' . $token . '?email=' . urlencode($user->email));
    
            // Send a custom email
            Mail::raw('Hi ' . $user->username . ', use this link to reset your password: ' . $resetLink, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Password Reset Request');
            });
    
            return redirect()->route('login')->with('status', 'Hi ' . $user->username . ', a password reset link has been sent to your email.');
        }
    
        return back()->with('error', 'Invalid email address.');
    }

    public function resetOldPassword(Request $request)
    {
        // 1) Validate…
        $request->validate([
            'email'          => 'required|email|exists:users,email',
            'old_password'   => 'required',
            'new_password'   => [
                'required','confirmed','min:8',
                'regex:/^[^\s]*$/','regex:/[A-Z]/','regex:/[@$]/','regex:/\d/',
            ],
        ], [ /* your custom messages */ ]);
    
        // 2) Retrieve the user
        $user = User::where('email', $request->email)->firstOrFail();
    
        // 3) Ensure it’s the logged-in user
        if ($user->id !== auth()->id()) {
            return back()->withErrors(['email' => 'That email does not belong to your account.']);
        }
    
        // 4) Verify old password
        if (! Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The current password is incorrect.']);
        }
    
        // 5) Update password only
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // 6) Redirect
        return redirect()
            ->route('login')
            ->with('status', 'Password updated successfully. You can now log in.');
    }
    

    

    public function handleResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^[^\s]*$/',     // No spaces
                'regex:/[A-Z]/',        // At least one uppercase letter
                'regex:/[@$]/',         // At least one special character
            ],
        ]);
    
        // Check token validity
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
    
        if (!$reset) {
            return back()->with('error', 'Invalid or expired token.');
        }
    
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();
    
        return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
    }




    public function resetPasswordForm($token, Request $request)
    {
        // If it's a GET request, show the reset password form
        if ($request->isMethod('get')) {
            return view('personal.public.auth.reset-password-form', [
                'token' => $token,
                'email' => $request->query('email'),
            ]);
        }

        // If it's a POST request, handle the password reset logic
        if ($request->isMethod('post')) {
            // Validate the input
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'token' => 'required',
                'new_password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^[^\s]*$/',     // No spaces
                    'regex:/[A-Z]/',        // At least one uppercase letter
                    'regex:/[@$]/',         // At least one special character
                ],
            ]);

            // Check token validity
            $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (!$reset) {
                return back()->with('error', 'Invalid or expired token.');
            }

            // Find the user and update the password
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Delete the reset token
            DB::table('password_resets')->where('email', $request->email)->delete();

            return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
        }
    }

    public function handleAdminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();

            // Check if user is an admin (role_id == 0)
            if ($user->role_id === 0) {
                return redirect()->route('admin.home')->with('status', 'Welcome Admin');
            }

            // If not admin, log out and deny access
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Access denied. Not an admin.');
        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials.')->withInput();
    }



      // GET: show the form
      public function showResetForm(Request $request, $token)
      {
          $email = $request->query('email'); // if you passed ?email=...
          return view('personal.public.auth.reset-password-form', compact('token','email'));
      }
  
      // POST: process the form
      public function handleResetForm(Request $request, $token)
      {
          $validated = $request->validate([
              'email'                 => 'required|email',
              'new_password'          => 'required|min:8|confirmed',
          ]);
  
          // Your password‐reset logic here...
  
          return redirect()->route('login')->with('status', 'Password updated!');
      }


      public function showOldPasswordForm()
{
    return view('personal.public.auth.reset-old-password'); 
    // create this Blade to contain your <form>
}

}
