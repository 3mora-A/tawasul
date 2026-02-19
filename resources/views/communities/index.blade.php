


{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="en"
      x-data="setup()"
      x-init="
        // apply the dark class on initial load
        document.documentElement.classList.toggle('dark', isDark);
        // set your color variables
        setColors(color);
      ">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Tawasul')</title>

  {{-- Legacy CSS (override Tailwind if necessary) --}}
  <link rel="stylesheet" href="/css/communities.css">
  <link rel="stylesheet" href="/css/posts.css">
  <link rel="stylesheet" href="/css/right-side.css">

  {{-- Font Awesome --}}
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  {{-- 1) Alpine.js (deferred so it’s ready before x-data runs) --}}
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  {{-- 2) Define your setup() *before* Alpine initializes --}}
  <script defer>
    window.setup = () => {
      // load stored preferences or defaults
      const storedDark = JSON.parse(localStorage.getItem('dark') || 'false');
      const storedColor = localStorage.getItem('color') || 'cyan';

      return {
        isDark: storedDark,
        color: storedColor,

        toggleTheme() {
          this.isDark = !this.isDark;
          localStorage.setItem('dark', this.isDark);
          document.documentElement.classList.toggle('dark', this.isDark);
        },

        setColors(color) {
          this.color = color;
          localStorage.setItem('color', color);
          // example of setting a CSS var; add more as needed
          document.documentElement.style.setProperty('--color-primary', `var(--color-${color})`);
        }
      }
    }
  </script>

  {{-- 3) Your custom JS (optional) --}}
  <script src="/js/post.js" defer></script>
  <script src="/js/community.js" defer></script>

  {{-- 4) Vite-managed Tailwind & app scripts --}}
  {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
  @vite(['resources/js/app.js'])

  {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>{{-- resources/views/communities/index.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="main-content">
  <div class="py-4 max-w-5xl">


  
  
    {{-- Header --}}
    <div class=" flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
      <div>
        <h1 class="text-2xl font-bold text-white-900 mb-4">Communities</h1>
        

        <p class="text-gray-500 ">Find communities you'll love</p><br>
      </div>
      <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
        <form action="{{ route('communities.index') }}" method="GET" class="flex-1 min-w-[280px]">
          <div class="relative">
            <input
              type="text"
              name="search"
              placeholder="Search communities..."
              value="{{ request('search') }}"
              class="
                       w-full
    bg-white dark:bg-gray-800
    border border-gray-200 dark:border-gray-700
    rounded-lg shadow-sm hover:shadow-md transition
    p-3
    placeholder-gray-400 dark:placeholder-gray-500
    placeholder-italic
    focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            
          </div>
        </form>
        
      </div>
    </div>
    
    
    
    
    
    
    
    

           {{-- Pagination --}}
          <section>
            <br>
            <h2 class="text-2xl font-bold text-white-900 mb-4">Suggested Communities</h2><br>
              @if($suggestedCommunities->count())
                <div class="space-y-3">
                  @foreach($suggestedCommunities as $community)
                  <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition p-6 flex">
                
                     {{-- Avatar --}}
                    <a href="{{ route('communities.show', $community) }}" class="hover:underline">

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
                    </a>
                    
                    {{-- Info --}}
                    <div class="ml-4 flex-1">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <a href="{{ route('communities.show', $community) }}" class="hover:underline">
                          T/{{ $community->name }}
                        </a>
                      </h3>
                      <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                        {{ $community->members_count }} members
                      </p>
                      <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                        {{ Str::limit($community->description, 100) }}
                      </p>
                      <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                        <span>Created {{ $community->created_at->format('M Y') }}</span>
                       
                      </div>
    
    
      
                  
                        </div>
                                     {{-- Buttons --}}
                        <div class="flex items-center justify-start space-x-2">
                          @auth
                            @if(auth()->id() === $community->creator_id)
                              <a href="{{ route('communities.edit', $community) }}"
                                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full text-sm">
                                Edit
                              </a>
                            @elseif($community->members->contains(auth()->user()))
                              <form method="POST" action="{{ route('communities.leave', $community) }}" class="inline">
                                @csrf
                                <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm">
                                  Leave
                                </button>
                              </form>
                            @else
                              <form method="POST" action="{{ route('communities.join', $community) }}" class="inline">
                                @csrf
                                <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-full text-sm">
                                  Join
                                </button>
                              </form>
                            @endif
                          @endauth
                        </div>
                    </div>
                    
                @endforeach
              </div>
      
              {{-- Pagination --}}
                  <div class="mt-8">
                    {{ $userCommunities->links() }}
                  </div>
                @else
                  <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-8 text-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No communities yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Join some communities to see them here.</p>
                    <a href="#discover" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full">Discover Communities</a>
                  </div>
            @endif
          </section>


      {{-- Your Communities --}}
      <section><br>
        <h2 class="text-2xl font-bold text-white-900 mb-4">Your Communities</h2>
  <br>
        @if($userCommunities->count())
          <div class="space-y-6">
            @foreach($userCommunities as $community)
              <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition p-6 flex">
                
                  {{-- Avatar --}}
                    <a href="{{ route('communities.show', $community) }}" class="hover:underline">

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
                    </a>
                
                {{-- Info --}}
                <div class="ml-4 flex-1">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    <a href="{{ route('communities.show', $community) }}" class="hover:underline">
                      T/{{ $community->name }}
                    </a>
                  </h3>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    {{ $community->members_count }} members
                  </p>
                  <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    {{ Str::limit($community->description, 100) }}
                  </p>
                  <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                    <span>Created {{ $community->created_at->format('M Y') }}</span>
                   
                  </div>


  
              
                    </div>
                                 {{-- Buttons --}}
                    <div class="flex items-center justify-start space-x-2">
                      @auth
                        @if(auth()->id() === $community->creator_id)
                          <a href="{{ route('communities.edit', $community) }}"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full text-sm">
                            Edit
                          </a>
                        @elseif($community->members->contains(auth()->user()))
                          <form method="POST" action="{{ route('communities.leave', $community) }}" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm">
                              Leave
                            </button>
                          </form>
                        @else
                          <form method="POST" action="{{ route('communities.join', $community) }}" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-full text-sm">
                              Join
                            </button>
                          </form>
                        @endif
                      @endauth
                    </div>
                </div>
                
            @endforeach
          </div>
  
          {{-- Pagination --}}
              <div class="mt-8">
                {{ $userCommunities->links() }}
              </div>
            @else
              <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-8 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No communities yet</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Join some communities to see them here.</p>
                <a href="#discover" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full">Discover Communities</a>
              </div>
        @endif

      </section>
  <br>
      {{-- Discover / Create --}}
      <section id="discover" class="space-y-6">
        <h2 class="text-2xl font-bold text-white-900 mb-4">Discover / Create</h2>
       
  
        {{-- If you have suggestedCommunities, show them similarly --}}
        @if(isset($suggestedCommunities) && $suggestedCommunities->count())
          <div class="space-y-6">
            @foreach($suggestedCommunities as $community)
              {{-- (Use the same card markup as above, or a simplified version) --}}
            @endforeach
          </div>
        @endif
  
        {{-- Create New Community --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-8 text-center m-0">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Can’t find what you’re looking for?</h3>
          <p class="text-gray-500 dark:text-gray-400 mb-4">Create a new community and start building!</p>
          <a href="{{ route('communities.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full">
            Create Community
          </a>
        </div>
      </section>
  
    </div>
  </div>
  @endsection

  