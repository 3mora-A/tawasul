<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\SocialAuthController;

use App\Models\User;
use App\Http\Controllers\{
    InformationController,
    SuggestedUserController,
    MainController,
    PostLoginController,
    PostController,
    LikeController,
    CommentController,
    ProfileController,
    ProfileMineController,
    UserController,
    FollowController,
    CommunityController,
    CommunityPostController,
    CommunityPostCommentController,
    SearchController,
    AuthController,
    AdminController,
    ReportController
};




/*
|--------------------------------------------------------------------------
| Authentication & Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('home-page');
});


// Social Login
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Static Pages
Route::view('/home-page',    'home-page')->name('home-page');

// Password Reset Request (send link)
Route::view('/reset-password-link',                    'personal.public.auth.reset-password-link')
     ->name('reset-password-link');
Route::post('/reset-password-link',                    [InformationController::class, 'handleResetPasswordLink']);

// Show Reset‐Form & Handle Reset (with token)
Route::get('/reset-password-form/{token}',             [InformationController::class, 'showResetForm'])
     ->name('reset-password-form');
Route::post('/reset-password-form/{token}',            [InformationController::class, 'handleResetForm']);

// Auth Forms
Route::view('/login',       'personal.public.auth.login')->name('login');
Route::view('/register',    'personal.public.auth.register')->name('register');

// Auth Actions
Route::post('/login',       [InformationController::class, 'handleLogin']);
Route::post('/register',    [InformationController::class, 'handleRegister']);

// (Optional) immediate post‐reset redirect
Route::view('/reset-password-success', 'personal.public.auth.reset-password-success')
     ->name('reset-password-success');

  

  
     
   // Display the change‐by‐old‐password form
Route::get('/reset-old-password', [InformationController::class, 'showOldPasswordForm'])
->name('reset-old-password.form');

// Handle the submission
Route::post('/reset-old-password', [InformationController::class, 'resetOldPassword'])
->name('reset-old-password');


/*
|--------------------------------------------------------------------------
| Routes Requiring Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile-mine',               [ProfileMineController::class, 'showProfile'])->name('profile-mine');
    Route::get('/profile-mine/followers',     [ProfileMineController::class, 'showFollowers'])->name('profile-mine.followers');
    Route::get('/profile-mine/following',     [ProfileMineController::class, 'showFollowing'])->name('profile-mine.following');
    Route::get('/profile-mine/posts',         [ProfileMineController::class, 'showPosts'])->name('profile-mine.posts');
    Route::get('/profile-mine/settings',      [ProfileMineController::class, 'showSettings'])->name('profile-mine.settings');
    Route::put('/profile-mine/updateInformation', [ProfileMineController::class, 'updateInformation'])->name('updateInformation');
    Route::put('/profile-mine/profile-picture',   [ProfileMineController::class, 'updateProfilePicture'])->name('updateProfilePicture');
    Route::put('/profile-mine/cover',             [ProfileMineController::class, 'updateCover'])->name('updateCover');
    Route::delete('/account',                     [ProfileMineController::class, 'destroy'])->name('account.destroy');

    // Logout
    Route::post('/logout',                                     [AuthController::class, 'logout'])->name('logout');

    // Follow / Unfollow Users
    Route::post('/follow/{user}',                              [FollowController::class, 'follow'])->name('user.follow');
    Route::post('/unfollow/{user}',                            [FollowController::class, 'unfollow'])->name('user.unfollow');

                // View Other Users
                // Public profile (via route-model binding)
            // Public profile
            Route::get('/user/{user}',                  [ProfileMineController::class, 'showPublicProfile'])
                ->name('profile.public');

            // Public profile tabs
            Route::get('/user/{user}/followers',        [ProfileMineController::class, 'showPublicFollowers'])
                ->name('profile.followers');
            Route::get('/user/{user}/following',        [ProfileMineController::class, 'showPublicFollowing'])
                ->name('profile.following');
            Route::get('/user/{user}/posts',            [ProfileMineController::class, 'showPublicPosts'])
                ->name('profile.posts');
          

   Route::get('/suggested-users',                             [SuggestedUserController::class, 'index']);

    // Personal Posts
    Route::get('/posts-mine',                                  [PostController::class, 'index'])->name('posts-mine');
    Route::post('/posts-mine',                                 [PostController::class, 'store'])->name('posts-mine.store');
    Route::delete('/posts/delete/{id}',                        [PostController::class, 'destroyById'])->name('posts.delete');

    // Comments & Likes on Personal Posts
    Route::post('/posts/{post}/comments',                      [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}',                       [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/posts/{post}/like',                          [LikeController::class, 'store']);
    Route::delete('/posts/{post}/like',                        [LikeController::class, 'destroy']);

    // Reporting Posts
    Route::post('/posts/{post}/report',                        [ReportController::class, 'store'])->name('posts.report');

    // Faculty Feed
    Route::get('/faculty/{faculty}',                           [PostController::class, 'facultyIndex'])->name('faculty.index');
    Route::post('/faculty/{faculty}',                          [PostController::class, 'facultyStore'])->name('faculty.store');

    /*
    |--------------------------------------------------------------------------
    | Community Management
    |--------------------------------------------------------------------------
    */

    // Community CRUD
    Route::get('/communities',                                 [CommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/create',                          [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities',                                [CommunityController::class, 'store'])->name('communities.store');
    Route::get('/communities/{community}',                      [CommunityController::class, 'show'])->name('communities.show');
    Route::get('/communities/{community}/edit',                 [CommunityController::class, 'edit'])->name('communities.edit');
    Route::put('/communities/{community}',                      [CommunityController::class, 'update'])->name('communities.update');
    Route::delete('/communities/{community}',                   [CommunityController::class, 'destroy'])->name('communities.destroy');

    // Membership
    Route::post('/communities/{community}/join',                [CommunityController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave',               [CommunityController::class, 'leave'])->name('communities.leave');

    // Community Posts
    Route::post('/communities/{community}/posts',               [CommunityPostController::class, 'store'])->name('communities.posts.store');
    Route::delete('/communities/{community}/posts/{post}',      [CommunityPostController::class, 'destroy'])->name('communities.posts.destroy');

    // Likes & Comments on Community Posts
    Route::post('/communities/{community}/posts/{post}/like',   [CommunityPostController::class, 'like'])->name('communities.posts.like');
    Route::delete('/communities/{community}/posts/{post}/like', [CommunityPostController::class, 'unlike'])->name('communities.posts.unlike');
    // Comments
    Route::post('/communities/{community}/posts/{post}/comments',                                [CommunityPostCommentController::class, 'store'])->name('communities.posts.comments.store');
    Route::delete('/communities/{community}/posts/{post}/comments/{comment}',                    [CommunityPostCommentController::class, 'destroy'])->name('communities.posts.comments.destroy');                                                           
 
                                                               
//report post 
Route::post('/communities/{community}/posts/{post}/report', [ReportController::class, 'storeCommunityPost'])->name('communities.posts.report');


});

/*
|--------------------------------------------------------------------------
| AJAX & Utility Routes
|--------------------------------------------------------------------------
*/

// Search users (autocomplete)
Route::get('/search-users', function (Request $request) {
    $q = $request->query('query', '');
    return User::where('username', 'LIKE', "%{$q}%")
               ->take(5)
               ->get(['id','username','profile_picture']);
});



     

Route::get('/admin/login', function () {
    return view('admin.login'); // Create this view in: resources/views/admin/login.blade.php
})->name('admin.login');

// Admin login form (GET)
Route::view('/admin/login', 'admin.login')->name('admin.login.view');

// Admin login handler (POST)
Route::post('/admin/login', [InformationController::class, 'handleAdminLogin'])->name('admin.login');


// -------------------------------
// Admin Protected Routes
// -------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/home', function () {
        return view('admin.home');
    })->name('admin.dashboard');

    // Dashboard (admin.home)
    Route::get('/home', [AdminController::class, 'dashboard'])
        ->name('admin.home');


    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');

    // Post Deletion
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');

    // Reports Management
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::delete('/reports/{report}', [AdminController::class, 'destroyReport'])->name('admin.reports.destroy');
    // Community Post Deletion from Admin Panel
Route::delete('/community-posts/{post}', [AdminController::class, 'deleteCommunityPost'])->name('admin.community-posts.delete');

    Route::get('/communities', [AdminController::class, 'communities'])->name('admin.communities');
    Route::delete('/admin/communities/{community}', [AdminController::class, 'deleteCommunity'])->name('admin.communities.delete');

   

});