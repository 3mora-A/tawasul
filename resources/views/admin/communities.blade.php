{{-- resources/views/admin/users.blade.php --}}
@extends('admin.dashboard')

@section('title','Users')

@section('content')
<div class="min-h-screen bg-white text-gray-900 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">All Communities</h2>

        @if ($communities->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($communities as $community)
                    
                    {{-- Community Header Card --}}
                    <div class="bg-[#2F3336] rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 w-full max-w-5xl mx-auto space-y-6">

                        {{-- Banner --}}
                        @if($community->banner_path)
                        <div class="h-32 sm:h-40 md:h-48 lg:h-56 bg-cover bg-center rounded-2xl"
                            style="background-image: url('{{ asset('storage/' . $community->banner_path) }}')">
                        </div>
                        @else
                        <div class="h-32 sm:h-40 md:h-48 lg:h-56 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl"></div>
                        @endif
                    
                        {{-- Profile + Info --}}
                        <div class="flex flex-col sm:flex-row items-center sm:items-start -mt-14 sm:-mt-20 px-2 sm:px-6">
                        
                        {{-- Avatar --}}
                        @if($community->icon_path)
                            <img src="{{ asset('storage/' . $community->icon_path) }}"
                                alt="{{ $community->name }}"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover
                    "
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Community';" />
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-indigo-600 flex items-center justify-center shadow">
                            <span class="text-white font-bold text-3xl sm:text-4xl uppercase">
                                {{ strtoupper(substr($community->name, 0, 1)) }}
                            </span>
                            </div>
                        @endif
                    
                        {{-- Text Info --}}
                        <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $community->name }}</h1>
                    
                            @if($community->description)
                            <p class="mt-2 text-sm sm:text-base text-gray-300 break-words max-w-full">
                                {{ $community->description }}
                            </p>
                            @endif
                    
                            <div class="mt-3 flex flex-wrap gap-3 text-xs sm:text-sm text-gray-400">
                            <span>
                                Created by 
                                <a href="{{ auth()->id() === $community->creator->id ? route('profile-mine') : route('profile.public', $community->creator) }}"
                                class="text-blue-400 hover:underline">
                                {{ $community->creator->username }}
                                </a>
                            </span>
                            <span>{{ $community->members_count ?? $community->members()->count() }} members</span>
                            <span>{{ $community->posts_count ?? $community->posts()->count() }} posts</span>
                            </div>
                        </div>
                    
                        {{-- Actions --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <a href="{{ route('communities.show', ['community' => $community->id]) }}"
                            class="inline-block px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded text-center">
                                View Community
                            </a>

                            <form action="{{ route('admin.communities.delete', $community->id) }}" method="POST"
                                onsubmit="return confirm('Delete this community and all its posts?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-block px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded text-center">
                                    Delete Community
                                </button>
                            </form>
                        </div>
                        </div>
                    </div>
  

                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $communities->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center mt-12 text-gray-600">No communities found.</div>
        @endif
    </div>
</div>
@endsection
