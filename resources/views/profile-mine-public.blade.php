<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Tawasul</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="/css/posts.css">
  <link rel="stylesheet" href="/css/profile.css">
  <link rel="stylesheet" href="/css/right-side.css">
<!-- favicon -->
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-top.png') }}">

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <!-- Popper.js (for tooltips, dropdowns, etc.) -->
  <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  

  
  <!-- Custom post interactions -->
<!-- in your head or just before </body> -->
<script defer src="{{ asset('js/post.js') }}"></script>
<script src="{{ asset('js/profile.js') }}"></script>

@vite(['resources/js/app.js'])

</head>

<body class="snippet-body">
  <div class="container" x-data="{ rightSide: false, leftSide: false }">
    @include('components.left-side')

    <div class="main">
      <div class="main-container">
        <div class="profile">

          <div class="profile-avatar">
            <div class="profile-img-container">
              <img
                src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default_profile.png') }}"
                alt="Profile"
                class="profile-img"
              />
            </div>
            <div class="profile-name">{{ $user->username }}</div>
          </div>

          <div class="cover-photo-wrapper">
            <img
              src="{{ $user->cover_picture ? asset('storage/' . $user->cover_picture) : asset('images/default_cover.png') }}"
              alt="Cover Photo"
              class="profile-cover"
            />
          </div>

          <div class="profile-menu flex space-x-6 border-b border-gray-700">
  <a
    href="{{ route('profile.public', $user->id) }}"
    class="profile-menu-link pb-2 {{ request()->routeIs('profile.public') ? 'active' : '' }}"
  >Details</a>

  <a
    href="{{ route('profile.followers', $user->id) }}"
    class="profile-menu-link pb-2 {{ request()->routeIs('profile.followers') ? 'active' : '' }}"
  >{{ $user->followers->count() }} followers</a>

  <a
    href="{{ route('profile.following', $user->id) }}"
    class="profile-menu-link pb-2 {{ request()->routeIs('profile.following') ? 'active' : '' }}"
  >{{ $user->following->count() }} following</a>

  <a
    href="{{ route('profile.posts', $user->id) }}"
    class="profile-menu-link pb-2 {{ request()->routeIs('profile.posts') ? 'active' : '' }}"
  >Posts</a>

   @auth
            @if(auth()->id() !== $user->id)
              <form
                method="POST"
                action="{{ $isFollowing ? route('user.unfollow', $user->id) : route('user.follow', $user->id) }}"
                class=""
              >
                @csrf
                <button type="submit" class="btn btn-follow {{ $isFollowing ? 'btn-following' : '' }}">
                  @if ($isFollowing)
                    Unfollow
                  @else
                    Follow
                  @endif
                </button>
              </form>
            @endif
          @endauth
</div>

         
        </div>

      <div class="profile-content">

          
        
@if($activeTab === 'details')
  @php
    $facultyGroups = \App\Models\User::facultyOptions();
    $isReadOnly = true;
  @endphp

  <div id="details" class="profile-section active">
    <div class="timeline-left">
      <div class="box">
        <div class="student-info-title">Student Information</div>
        <div class="info">
          <div class="info-item">
            <strong>Name:</strong>
            <span>{{ $user->username ?: 'No name provided' }}</span>
          </div>
          <div class="info-item">
            <strong>Studies at:</strong>
            <span>{{ $user->university_name ?? 'No university specified' }}</span>
          </div>
          <div class="info-item">
            <strong>Faculty:</strong>
            <span>{{ $user->faculty_label ?? 'No faculty listed' }}</span>
          </div>
          <div class="info-item">
            <strong>Major:</strong>
            <span>{{ $user->major ?: 'Major not specified' }}</span>
          </div>
          <div class="info-item bio-box">
            <strong>Bio:</strong>
            <span>{{ $user->bio ?? 'No bio available' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif


        {{-- Followers Tab --}}
        @if($activeTab === 'followers')
          <div id="followers" class="profile-section active">
            <div class="followers-list">
              <h3 class="section-title">Followers</h3>

              @forelse($followers as $follower)
                <a href="{{ route('profile.public', $follower->id) }}"
                  class="follower-card-link"
                >
                  <div class="follower-card">
                    <img 
                      src="{{ $follower->profile_picture 
                        ? asset('storage/' . $follower->profile_picture)
                        : asset('images/default_profile.png') }}" 
                      alt="{{ $follower->username }}" 
                      class="follower-avatar"
                    >
                    <div class="follower-name">{{ $follower->username }}</div>
                  </div>
                </a>
              @empty
                <p class="text-gray-400">No followers yet.</p>
              @endforelse
            </div>
          </div>
        @endif


        {{-- Following Tab --}}
        @if($activeTab === 'following')
          <div id="following" class="profile-section active">
            <div class="followers-list">
              <h3 class="section-title">Following</h3>

              @forelse($following as $followed)
                <a href="{{ route('profile.public', $followed->id) }}"
                  class="follower-card-link"
                  style="text-decoration: none; color: inherit;"
                >
                  <div class="follower-card">
                    <img 
                      src="{{ $followed->profile_picture 
                        ? asset('storage/' . $followed->profile_picture)
                        : asset('images/default_profile.png') }}" 
                      alt="{{ $followed->username }}" 
                      class="follower-avatar"
                    >
                    <div class="follower-name">{{ $followed->username }}</div>
                  </div>
                </a>
              @empty
                <p class="text-gray-400">Not following anyone yet.</p>
              @endforelse
            </div>
          </div>
        @endif



                        {{-- Posts Tab --}}
                        @if($activeTab === 'posts')
                          <div id="posts" class="profile-section active">
                      
                            {{-- Header + selector --}}
                            <div class="flex justify-between items-center px-4 py-3 rounded-lg w-full mt-4">
                              <h2 class="text-lg font-semibold text-gray-100">Posts</h2>
                              <div class="relative w-40">
                                <select
                                id="postFilter"
                                  class="appearance-none bg-[#2F3336] text-gray-200 text-sm rounded-lg py-2 pl-3 pr-12 focus:outline-none"
                                >
                                  <option value="feed">Public Posts</option>
                                  <option value="faculty">Faculty Posts</option>
                                  <option value="community">Community Posts</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                              
                                </div>
                              </div>
                            </div>

                      
                            {{-- Feed --}}
                            <div id="tab-feed" class="tab-section w-full">
                              @forelse($feedPosts as $post)
                                @include('partials.single-post-user',['post'=>$post])
                              @empty
                                <p class="text-gray-400">No Public posts to show.</p>
                              @endforelse
                            </div>
                      
                            

                            {{-- Faculty --}}
                            <div id="tab-faculty" class="tab-section w-full hidden">
                              @forelse($facultyPosts as $post)
                                @include('partials.single-post-user',['post'=>$post])
                              @empty
                                <p class="text-gray-400">No Faculty posts to show.</p>
                              @endforelse
                            </div>
                      
                            {{-- Community --}}
                            <div id="tab-community" class="tab-section w-full hidden">
                              @forelse($communityPosts as $post)
                                @include('partials.single-post-user',['post'=>$post])
                              @empty
                                <p class="text-gray-400">No Community posts to show.</p>
                              @endforelse
                            </div>
                      
                          </div>
                        @endif


        </div>
      </div>
    </div>

    @include('components.right-side')
  </div>

  
</body>
</html>
