<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Models\User;
class PostController extends Controller
{
    /**
     * Show all posts for the authenticated user.
     */
    public function facultyIndex()
{
    // 1) Get the current user’s faculty (or null)
    $faculty = Auth::user()->faculty;

    // 2) Query posts for that faculty
    $posts = Post::with('user')
                 ->when($faculty, fn($q) => $q->where('faculty', $faculty))
                 ->latest()
                 ->get();

    // 3) Pass both to the view
    return view('faculty', [
        'facultyName' => $faculty,   // <-- new key
        'posts'       => $posts,
      ]);
      
}

public function index()
{
    $posts = Post::with('user')
        ->where(function ($q) {
            $q->whereNull('faculty')->orWhere('faculty', '');
        })
        ->latest()
        ->get();

    return view('posts-mine', compact('posts'));
}


    /**
     * Store a new post in the database.
     */
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required_without:media|string|max:1000',
        'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm,quicktime',
    ]);

    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $mime = $file->getMimeType();
        $size = $file->getSize(); // in bytes

        // Separate size checks
        if (str_starts_with($mime, 'image') && $size > 20 * 1024 * 1024) {
            return back()->withErrors(['media' => 'Image size must not exceed 20MB.'])->withInput();
        }

        if (str_starts_with($mime, 'video') && $size > 500 * 1024 * 1024) {
            return back()->withErrors(['media' => 'Video size must not exceed 500MB.'])->withInput();
        }
    }

    $post = new Post();
    $post->user_id = Auth::id();
    $post->faculty = null;
    $post->content = $request->input('content');

    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $path = $file->store('posts/uploads/media', 'public');

        if (str_starts_with($file->getMimeType(), 'video')) {
            $post->video_path = $path;
        } else {
            $post->image_path = $path;
        }
    }

    $post->save();

    return redirect()->route('posts-mine')->with('success', 'Post created successfully.');
}


    /**
     * Delete a specific post if the user is authorized.
     */
    public function destroyById($id)
    {
        $post = Post::findOrFail($id);
    
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        // Delete media files if exist
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->video_path) {
            Storage::disk('public')->delete($post->video_path);
        }
    
        $post->delete();
    
        return back()->with('success', 'Post deleted successfully.');
    }
    
    

    public function facultyStore(Request $request, string $faculty)
    {
        $request->validate([
            'content' => 'required_without:media|string|max:1000',
            'media'   => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm,quicktime',
        ]);
    
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mime = $file->getMimeType();
            $size = $file->getSize(); // in bytes
    
            // Separate size checks
            if (str_starts_with($mime, 'image') && $size > 20 * 1024 * 1024) {
                return back()->withErrors(['media' => 'Image size must not exceed 20MB.'])->withInput();
            }
    
            if (str_starts_with($mime, 'video') && $size > 500 * 1024 * 1024) {
                return back()->withErrors(['media' => 'Video size must not exceed 500MB.'])->withInput();
            }
        }
    
        $post = new Post();
        $post->user_id = Auth::id();
        $post->faculty = Auth::user()->faculty ?? null;
        $post->content = $request->input('content');
    
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('faculty/uploads/media', 'public');
    
            if (str_starts_with($file->getMimeType(), 'video')) {
                $post->video_path = $path;
            } else {
                $post->image_path = $path;
            }
        }
    
        $post->save();
    
        return redirect()
        ->route('faculty.index', $faculty)
        ->with('success', 'Post created successfully.');
           
            }

   
    
}



