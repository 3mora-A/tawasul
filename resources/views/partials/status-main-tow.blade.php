 
                        <div class="status-main-post space-x-2">
                          <div class="profile-section-post">
                                  <!-- 🟢 POST HEADER: Top of the post -->
                          <!-- 🟢 POST HEADER: Top of the post -->

                          <!-- 🟢 POST HEADER: Top of the post -->
                              <div class="post-header-post flex items-center">
                              @php
                              $profileUrl = Auth::id() === $post->user->id
                                              ? route('profile-mine')
                                              : route('profile.public', $post->user->id);
                              @endphp
                          
                              {{-- Avatar (clickable) --}}
                              <a href="{{ $profileUrl }}" class="flex-shrink-0">
                              <img
                                  src="{{ $post->user->profile_picture
                                          ? asset('storage/'.$post->user->profile_picture)
                                          : asset('images/default_profile.png') }}"
                                  alt="{{ $post->user->username }}’s avatar"
                                  class="profile-img-post rounded-full"
                              />
                              </a>
                          
                              {{-- add explicit ml-6 here for 24px gap --}}
                              <div class="album-detail flex-1 ml-6">
                              {{-- Username + badge --}}
                              <div class="flex items-center space-x-2">
                                  <a href="{{ $profileUrl }}"
                                  class="text-white text-base font-semibold hover:underline"
                                  >
                                  {{ $post->user->username }}
                                  </a>
                          
                                 
                              </div>
                          
                              {{-- Timestamp --}}
                              <div class="flex items-center space-x-1 text-xs text-gray-400 mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg"
                                      class="w-4 h-4"
                                      fill="none" viewBox="0 0 24 24"
                                      stroke="currentColor">
                                  <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 
                                          002-2V7a2 2 0 00-2-2H5a2 2 0 
                                          00-2 2v12a2 2 0 002 2z"/>
                                  </svg>
                                  <time datetime="{{ $post->created_at->toIso8601String() }}">
                                  {{ $post->created_at->diffForHumans() }}
                                  </time>
                              </div>
                          </div>

          </div>
          
          




      <!-- النقاط الثلاث داخل زر، في أقصى اليمين -->
      <div class="menu-wrapper">

          <!-- Button -->
          <div class="menu-container-post">
          <button class="intro-menu-post" onclick="toggleMenu(event)">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-ellipsis-icon">
              <circle cx="12" cy="12" r="1"/>
              <circle cx="19" cy="12" r="1"/>
              <circle cx="5" cy="12" r="1"/>
              </svg>
          </button>
          </div>
      
          <!-- Dropdown Menu -->
      
          <div class="dropdown-menu" id="albumDropdown">
            <ul>
                {{-- Only show delete if user owns the post --}}
                @if(Auth::check() && Auth::id() === $post->user_id)
                    @php
                        $isCommunityPost = isset($post->community_id);
                    @endphp
        
                    <form 
                        action="{{ $isCommunityPost 
                            ? route('communities.posts.destroy', [$post->community_id, $post->id]) 
                            : route('posts.delete', $post->id) 
                        }}" 
                        method="POST" 
                        onsubmit="return confirm('Are you sure you want to delete this post?');"
                    >
                        @csrf
                        @method('DELETE')
                        <li style="list-style: none; padding: 0; margin: 0;">
                            <button type="submit" style="all: unset; width: 100%; cursor: pointer; display: flex; align-items: center; padding: 8px 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                <span style="margin-left: 8px;">Delete Post</span>
                            </button>
                        </li>
                    </form>
                @endif
        
                {{-- Report for all users --}}
                @php
                    $isCommunityPost = isset($post->community_id);
                    $reportRoute = $isCommunityPost 
                        ? route('communities.posts.report', [$post->community_id, $post->id]) 
                        : route('posts.report', $post->id);
                @endphp
        
                <li style="list-style: none; padding: 0; margin: 0;">
                    <form action="{{ $reportRoute }}" method="POST">
                        @csrf
                        <input type="hidden" name="reason" value="Inappropriate content">
                        <button type="submit" style="all: unset; cursor: pointer; display: flex; align-items: center; padding: 8px 12px; width: 100%;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                            <span style="margin-left: 8px;">Report Post</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        
              
      </div>