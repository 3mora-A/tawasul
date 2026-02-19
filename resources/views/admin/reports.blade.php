@extends('admin.dashboard')

@section('title', 'Reports')

@section('content')
<div class="min-h-screen bg-white text-gray-900 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Reported Posts</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($reports as $report)
            <div class="bg-white border border-gray-200 rounded-lg shadow p-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">Report #{{ $report->id }}</h3>
                    <span class="text-sm text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                </div>

                <p class="text-sm text-gray-600 mb-2">Reported by: 
                    <span class="font-medium text-gray-800">{{ $report->reporter->username ?? 'Unknown' }}</span>
                </p>

                @if ($report->communityPost)
                    {{-- Community Post --}}
                    <div class="bg-gray-50 border border-gray-200 rounded p-3 mb-4">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $report->communityPost->community->icon ?? 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold">{{ $report->communityPost->community->name }}</p>
                                @if($report->communityPost->community->banner)
                                    <img src="{{ asset('storage/' . $report->communityPost->community->banner) }}" class="mt-2 rounded w-full max-h-48 object-cover">
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ $report->communityPost->user->profile_picture ?? 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full">
                            <span class="font-medium">{{ $report->communityPost->user->username ?? 'Unknown' }}</span>
                        </div>

                        <p class="text-gray-800 mb-2">{{ $report->communityPost->content }}</p>

                        @if($report->communityPost->image_path)
                            <img src="{{ asset('storage/'.$report->communityPost->image_path) }}" class="rounded w-full max-h-60 object-cover">
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('admin.community-posts.delete', $report->communityPost) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                Delete Community Post
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Delete this report?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 border border-red-600 text-red-600 text-sm rounded hover:bg-red-50">
                                Delete Report
                            </button>
                        </form>
                    </div>

                @elseif($report->post)
                    {{-- Regular Post --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6 shadow-sm">
                            <!-- Post Author Info -->
                            <div class="flex items-center gap-4 mb-3">
                                <img 
                                    src="{{ Str::startsWith($report->post->user->profile_picture, ['http://', 'https://']) 
                                        ? $report->post->user->profile_picture 
                                        : ($report->post->user->profile_picture 
                                            ? asset('storage/' . $report->post->user->profile_picture) 
                                            : asset('images/default_profile.png')) }}" 
                                    alt="User profile picture" 
                                    class="w-12 h-12 rounded-full border border-gray-300 shadow-sm object-cover"
                                />
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $report->post->user->username ?? 'Unknown' }}</p>
                                    <span class="text-xs text-gray-500">{{ $report->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <p class="text-gray-700 mb-3 whitespace-pre-line">{{ $report->post->content }}</p>

                            <!-- Attached Image -->
                            @if($report->post->image_path)
                                <img src="{{ asset('storage/'.$report->post->image_path) }}"
                                    class="rounded-md w-full max-h-80 object-cover border border-gray-200">
                            @endif
                        </div>


                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('admin.posts.delete', $report->post) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                Delete Post
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Delete this report?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 border border-red-600 text-red-600 text-sm rounded hover:bg-red-50">
                                Delete Report
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
