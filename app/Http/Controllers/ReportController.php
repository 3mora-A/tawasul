<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Report;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
     //store new report
    public function store(Request $request,Post $post)
    {
        //prevent duplicate reports
        if($post->reports()->where('user_id',auth()->id())->exists()){
            return back()->with('error', 'You already reported this post');
        }

        Report::create([
            'user_id'=> auth()->id(),
            'post_id'=>$post->id
        ]);

        return back()->with('success','Post reported successfully');
    }


    public function storeCommunityPost($communityId, CommunityPost $post, Request $request)
{
    $userId = auth()->id();

    $alreadyReported = Report::where('user_id', $userId)
        ->where('community_post_id', $post->id)
        ->exists();

    if ($alreadyReported) {
        return back()->with('message', 'You already reported this post.');
    }

    Report::create([
        'user_id' => $userId,
        'community_post_id' => $post->id,
    ]);

    return back()->with('success', 'Community post reported successfully.');
}
    public function index(Request $request)
    {
        $sort = $request->get('sort');
        
        if($sort === 'most_reported'){
            $reports = DB::table('reports')
        ->select('post_id', DB::raw('COUNT(*) as total_reports'))
        ->groupBy('post_id')
        ->orderByDesc('total_reports')
        ->paginate(10);
          return view('admin.reports', compact('reports', 'posts', 'sort'));
        }
        //newest

        $reports = Report::with(['post.user','reporter'])
        ->orderBy('created_at','desc')
        ->paginate(10);
        
        return view('admin.reports', compact('reports', 'sort'));
    }



}
