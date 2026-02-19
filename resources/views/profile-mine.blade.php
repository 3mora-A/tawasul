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

<body class='snippet-body'>
  
  <div class="container" x-data="{ rightSide: false, leftSide: false }">
      

      @include('components.left-side')
  

      <div class="main">
        
          <div class="main-container">

              <div class="profile">

                  <div class="profile-avatar">

                    

                    <form id="uploadForm" action="{{ route('updateProfilePicture') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                      @csrf
                      @method('PUT')
                      <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" />
                    </form>
                    
                    <div class="profile-img-container" style="position: relative; display: inline-block;">
                      <img 
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default_profile.png') }}" 
                        alt="Profile" 
                        class="profile-img" 
                      onclick="openProfilePictureDialog()"
                      />
                    
                      <div 
                        class="camera-icon" 
                        onclick="openProfilePictureDialog()"                     
                      >
                        <!-- Camera SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="lucide lucide-camera">
                          <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                          <circle cx="12" cy="13" r="3"/>
                        </svg>
                      </div>
                    </div>
                  
                    
                    <div class="profile-name">{{ $user->username }}</div>
                    </div>
                  
                    
                    <div class="cover-photo-wrapper">
                      <!-- Cover Image -->
                      <img 
                        src="{{ $user->cover_picture ? asset('storage/' . $user->cover_picture) : asset('images/default_cover.png') }}" 
                        alt="Cover Photo" 
                        class="profile-cover"
                      >
                    
                      <!-- Hidden Form -->
                      <form id="coverUploadForm" action="{{ route('updateCover') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="file" name="cover_picture" id="coverInput" accept="image/*">
                      </form>
                    
                      <!-- Trigger Button -->
                      <div class="edit-cover-box" style="cursor: pointer;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                          <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Edit Cover
                      </div>
                    </div>
                    
                    
                    
                  
                    <div class="profile-menu flex space-x-6 border-b border-gray-700">
                      <a
                        href="{{ route('profile-mine') }}"
                        class="profile-menu-link pb-2 {{ request()->routeIs('profile-mine') ? 'active' : '' }}"
                      >Details</a>
                    
                      <a
                        href="{{ route('profile-mine.followers') }}"
                        class="profile-menu-link pb-2 {{ request()->routeIs('profile-mine.followers') ? 'active' : '' }}"
                      >{{ $followers->count() }} followers</a>
                    
                      <a
                        href="{{ route('profile-mine.following') }}"
                        class="profile-menu-link pb-2 {{ request()->routeIs('profile-mine.following') ? 'active' : '' }}"
                      >{{ $following->count() }} following</a>
                    
                      <a
                        href="{{ route('profile-mine.posts') }}"
                        class="profile-menu-link pb-2 {{ request()->routeIs('profile-mine.posts') ? 'active' : '' }}"
                      >Posts</a>
                    
                      <a
                        href="{{ route('profile-mine.settings') }}"
                        class="profile-menu-link pb-2 {{ request()->routeIs('profile-mine.settings') ? 'active' : '' }}"
                      >Settings</a>
                    </div>
                    
                    

                  
                  
                  

                  </div>


                    <div class="profile-content">

                        <!-- Details tab with your info -->
                        @if($activeTab==='details')
                          <div class="profile-section active" id="details">
                            <div class="timeline-left">
                              <div class="box">

                                <div id="message-box">
                                  @if(session('status'))
                                    <div class="alert alert-success">
                                      {{ session('status') }}
                                    </div>
                                  @endif
                              
                                  @if(session('error'))
                                    <div class="alert alert-danger">
                                      {{ session('error') }}
                                    </div>
                                  @endif
                                </div>

                                <div class="student-info-title">
                                  Student Information
                                  <div>
                                  <!-- before -->
                                    <a href="#"
                                    class="cancel-button"
                                    id="cancel-btn">
                                    Cancel
                                    </a>

                                  


                                    <a href="#" class="edit-button" aria-label="Edit" id="edit-btn">Edit</a>
                                  </div>
                                </div>
                                <div class="info">

                                  {{-- Name (editable text) --}}
                                  <div class="info-item">
                                    <strong>Name:</strong>
                                    <span class="editable" contenteditable="false" data-key="name">{{ $user->username }}</span>
                                  </div>

                                  <div class="info-item">
                                    <strong>Studies at:</strong>
                                    <select name="university" data-key="university" class="editable" disabled>
                                      <option value="" {{ empty($user->university) ? 'selected' : '' }} disabled>Select a University</option>

                                      <option value="najah" {{ $user->university == 'najah' ? 'selected' : '' }}>
                                        An-Najah National University – جامعة النجاح الوطنية
                                      </option>
                                      <option value="birzeit" {{ $user->university == 'birzeit' ? 'selected' : '' }}>
                                        Birzeit University – جامعة بيرزيت
                                      </option>
                                      <option value="alquds" {{ $user->university == 'alquds' ? 'selected' : '' }}>
                                        Al-Quds University – جامعة القدس
                                      </option>
                                      <option value="khalil" {{ $user->university == 'khalil' ? 'selected' : '' }}>
                                        Hebron University – جامعة الخليل
                                      </option>
                                      <option value="khodori" {{ $user->university == 'khodori' ? 'selected' : '' }}>
                                        Palestine Technical University – Kadoorie – جامعة فلسطين التقنية – خضوري
                                      </option>
                                      <option value="alqods_open" {{ $user->university == 'alqods_open' ? 'selected' : '' }}>
                                        Al-Quds Open University – جامعة القدس المفتوحة
                                      </option>
                                      <option value="ppu" {{ $user->university == 'ppu' ? 'selected' : '' }}>
                                        Palestine Polytechnic University – جامعة بوليتكنك فلسطين
                                      </option>
                                      <option value="aaup" {{ $user->university == 'aaup' ? 'selected' : '' }}>
                                        Arab American University – الجامعة العربية الأمريكية
                                      </option>
                                      <option value="istaqlal" {{ $user->university == 'istaqlal' ? 'selected' : '' }}>
                                        Al-Istiqlal University – جامعة الاستقلال
                                      </option>

                                    </select>
                                  </div>
                                  

                                  @php
                                    
                                      $facultyGroups = \App\Models\User::facultyOptions();
                                      $isReadOnly = true;


                                  @endphp


                                  {{-- 4) Your original wrapper, with the new grouped <select> --}}
                                  <div class="info-item">
                                    <strong>Faculty:</strong>
                                    <select
                                        name="faculty"
                                        data-key="faculty"
                                        class="editable form-select faculty-select"
                                        {{ $isReadOnly ? 'disabled' : '' }}
                                    >
                                      {{-- placeholder --}}
                                      <option value="" disabled {{ !$user->faculty ? 'selected' : '' }}>
                                        Select Faculty
                                      </option>

                                      {{-- loop through each group --}}
                                      @foreach($facultyGroups as $groupLabel => $faculties)
                                        <optgroup label="{{ $groupLabel }}">
                                          @foreach($faculties as $code => $label)
                                            <option
                                              value="{{ $code }}"
                                              {{ $user->faculty === $code ? 'selected' : '' }}
                                            >
                                              {{ $label }}
                                            </option>
                                          @endforeach
                                        </optgroup>
                                      @endforeach
                                    </select>
                                  </div>
                          

                                {{-- Major --}}
                                <div class="info-item">
                                  <strong>Major:</strong>
                                  <span
                                    class="editable"
                                    contenteditable="false"
                                    data-key="major"
                                    data-placeholder="Write a major"
                                  >{{ $user->major }}</span>
                                </div>
                                  

                                {{-- Bio --}}
                                <div class="info-item bio-box">
                                  <strong>Bio:</strong>
                                  <span
                                    class="editable"
                                    contenteditable="false"
                                    data-key="bio"
                                    data-placeholder="Write a bio"
                                  >{{ $user->bio }}</span>
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
                  
                

                        
                        {{-- SETTINGS --}}
                        @if($activeTab === 'settings')
                          <div
                            id="settings"
                            class="profile-section active px-4 py-6 mt-50"   
                          >
                            <div class="max-w-2xl mx-auto space-y-6"><br><br>

                              {{-- Header --}}
                              <div class="flex items-center justify-between">
                                <h2 class="text-2xl font-semibold text-gray-100">Settings</h2>
                              </div>

                              {{-- Account Info Card --}}
                              <div class="   p-6 space-y-4">
                                <h3 class="text-xl font-medium text-gray-200">Account</h3>
                                <p class="text-gray-400">
                                  Manage your account settings and preferences here.
                                </p>

                                {{-- Delete Account Form with native alert --}}
                                <form
                                  method="POST"
                                  action="{{ route('account.destroy') }}"
                                  onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');"
                                  class="mt-4"
                                >
                                  @csrf
                                  @method('DELETE')
                                  <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-sm transition"
                                  >
                                    Delete My Account
                                  </button>
                                </form>
                              </div>

                            </div>
                          </div>
                        @endif








                    </div>
                    
              </div>

          
          <div>
        
      </div>
  </div>
        @include('components.right-side')



  <!-- Global JavaScript variables for use in external scripts -->
  <script>
      window.profileUpdateUrl = @json(route('updateInformation'));
      window.csrfToken = @json(csrf_token());
  </script>


</body>
</html>