@extends('layouts.app')

@section('content')
  <div class="w-full px-4 space-y-6">

    {{-- Community Header Card --}}
    <div class="relative w-full max-w-[864px] mx-auto bg-[#2F3336] p-4 sm:p-6 md:p-8 lg:p-10 rounded-2xl shadow-lg space-y-6">
      {{-- Banner --}}
      @if($community->banner_path ?? false)
        <div
          class="h-32 sm:h-40 md:h-48 lg:h-56 bg-cover bg-center rounded-2xl"
          style="background-image:url('{{ asset('storage/' . $community->banner_path) }}')"
        ></div>
      @else
        <div class="h-32 sm:h-40 md:h-48 lg:h-56 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl"></div>
      @endif
    
    <div class="flex flex-col sm:flex-row items-center sm:items-start mt-5 px-2 sm:px-6">
        {{-- Avatar --}}
        @if($community->icon_path)
          <img
            src="{{ asset('storage/'.$community->icon_path) }}"
            alt="{{ $community->name }}"
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover "
            onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=Community'"
          />
        @else
          <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-indigo-600 flex items-center justify-center">
            <span class="text-white font-bold text-4xl sm:text-5xl uppercase">
              {{ strtoupper(substr($community->name, 0, 1)) }}
            </span>
          </div>
        @endif
    
        {{-- Info --}}
        <div class="mt-4 sm:mt-0 sm:ml-6 flex-1 max-w-full">
          <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-100">
            T/{{ $community->name }}
          </h1>
    
        @if($community->description)
          <p
  class="-mt-[5px] text-sm sm:text-base text-gray-300 break-words max-w-full"
  style="white-space: pre-line; text-indent: -5ch;"
>
  {{ $community->description }}
</p>

        @endif

    
          <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-6 text-xs sm:text-sm text-gray-400">
            <span>
              Created by
              <a href="{{ auth()->id() === $community->creator->id
                         ? route('profile-mine')
                         : route('profile.public', $community->creator) }}"
                 class="text-blue-400 hover:underline">
                {{ $community->creator->username }}
              </a>
            </span>
            <span>{{ $community->members_count ?? $community->members()->count() }} members</span>
            <span>{{ $community->posts_count ?? $community->posts()->count() }} posts</span>
          </div>
        </div>
    
        {{-- Actions --}}
        <div class="mt-4 sm:mt-0 sm:ml-6 flex space-x-2">
          @auth
            @if(Auth::id() === $community->creator_id)
              <a href="{{ route('communities.edit', $community) }}"
                 class="px-3 sm:px-4 py-1 sm:py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full text-xs sm:text-sm">
                Edit
              </a>
            @elseif($community->members->contains(Auth::user()))
              <form method="POST" action="{{ route('communities.leave', $community) }}">
                @csrf
                <button class="px-3 sm:px-4 py-1 sm:py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs sm:text-sm">
                  Leave
                </button>
              </form>
            @else
              <form method="POST" action="{{ route('communities.join', $community) }}">
                @csrf
                <button class="px-3 sm:px-4 py-1 sm:py-2 bg-green-500 hover:bg-green-600 text-white rounded-full text-xs sm:text-sm">
                  Join
                </button>
              </form>
            @endif
          @endauth
        </div>
      </div>
    </div>
    
    {{-- Sorting & Filter Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-center bg-[#24273b]">
      <h2 class="text-lg font-semibold text-gray-100 mb-3 sm:mb-0">Community Posts</h2>
      <div class="flex items-center space-x-4">
        <form action="{{ route('communities.show', $community) }}" method="GET" class="flex items-center space-x-4">
          <div class="relative inline-block">
            <select
              name="sort"
              onchange="this.form.submit()"
              class="appearance-none bg-[#2F3336] text-gray-200 text-sm rounded-lg py-2 pl-3 pr-8 focus:outline-none"
            >
              <option value="newest" {{ $sortMethod==='newest'?'selected':'' }}>Newest</option>
              <option value="top"    {{ $sortMethod==='top'   ?'selected':'' }}>Top</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
              <!-- down-arrow SVG -->
              <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        </form>
        
        
      </div>
    </div>

    {{-- Post Creation --}}
    @auth
      @if($community->members->contains(auth()->user()))
        <div id="post-create" class="bg-[#24273b]">
          @include('communities.post-creation', ['community' => $community])
        </div>
      @endif
    @endauth

    {{-- Posts Feed --}}
    <div class="space-y-6">
      @foreach($posts as $post)
        <div class="bg-[#24273b] overflow-hidden">
          @include('communities.album-post', ['post' => $post, 'community' => $community])
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
      {{ $posts->links() }}
    </div>

  </div>
@endsection
