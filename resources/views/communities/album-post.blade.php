
<div class="album box"
id="community-post-{{ $post->id }}"
data-community-id="{{ $community->id }}">
        
                        
@include('partials.status-main-tow')   




</div>

</div>

          <!-- 🟣 POST CONTENT: Description and Photo -->
          <div class="album-content">
              <div class="post-description"
     style="white-space: pre-line; 
            padding-left: 2ch;   
            text-indent: -2ch;">   
  {{ $post->content }}
</div>

              @if ($post->image_path)
                  <div class="album-photos-post">
                      <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="album-photo">
                  </div>
              @elseif ($post->video_path)
                  <div class="album-photos-post">
                      <video controls class="album-photo-post">
                          <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4">
                      </video>
                  </div>
              @endif
          </div>

          <div class="album-actions">
              <!-- Like Button -->
               <!-- Like Button -->
                  <a href="javascript:void(0);"
                  class="album-action collapsed like-button {{ $post->likes->where('user_id', auth()->id())->isNotEmpty() ? 'liked' : '' }}"
                  data-post-id="{{ $post->id }}"
                  data-community-id="{{ $community->id }}"
                  >
                  <svg stroke="currentColor" stroke-width="2"
                      fill="{{ $post->likes->where('user_id', auth()->id())->isNotEmpty() ? 'red' : 'none' }}"
                      stroke-linecap="round" stroke-linejoin="round"
                      viewBox="0 0 24 24" width="24" height="24">
                  <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06
                              a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23
                              l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                  </svg>
                  <span class="like-count">{{ $post->likes->count() }}</span>
                  </a>


              <!-- Comment -->
              <a href="javascript:void(0);" class="album-action collapsed" onclick="showComment({{ $post->id }})">
                  <svg stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  viewBox="0 0 24 24" width="24" height="24">
                  <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                  </svg>
                  <span id="comment-count">0</span>
              </a>

              <!-- Share -->
              <a href="javascript:void(0);" class="album-action collapsed">
                  <svg stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  viewBox="0 0 24 24" width="24" height="24">
                  <path d="M17 1l4 4-4 4" />
                  <path d="M3 11V9a4 4 0 014-4h14" />
                  <path d="M7 23l-4-4 4-4" />
                  <path d="M21 13v2a4 4 0 01-4 4H3" />
                  </svg>
                  <span>0</span>
              </a>
          </div>


          <!-- Comment trigger -->
          <div class="expanded-text" id="comment-show-{{ $post->id }} "> 
          </div>

          <!-- Comment input box -->
          <div class="expanded" id="comment-expanded-{{ $post->id }}" style="display: none;">
          <textarea id="comment-input-{{ $post->id }}" placeholder="Write a comment..."></textarea>
          <div class="actions">
              <button class="cancel-btn" onclick="cancelComment({{ $post->id }})">Cancel</button>
              <button 
              class="comment-btn" 
              onclick="submitComment({{ $post->id }})"
            >
              Comment
            </button>
                            </div>
          </div>


           <!-- ✅ Only ONE comments container per community post -->
        <div class="comments-wrapper">
        
            @foreach ($post->comments as $comment)
              <div class="comment-box">
                <a href="{{ Auth::id() === $comment->user->id
                             ? route('profile-mine')
                             : route('profile.public', $comment->user->id) }}">
                  <img 
                    src="{{ $comment->user->profile_picture
                              ? asset('storage/' . $comment->user->profile_picture)
                              : asset('images/default_profile.png') }}"
                    class="comments-profile-img" 
                  />
                </a>
          
                <div class="comment-content">
                  <strong>{{ $comment->user->username }}</strong>
                  <span class="timestamp">• {{ $comment->created_at->diffForHumans() }}</span>
                  <div class="comment-text">{{ $comment->content }}</div>
                </div>
          
                @if(Auth::id() === $comment->user_id)
                  <form 
                    action="{{ route('communities.posts.comments.destroy', [
                                'community' => $community->id,
                                'post'      => $post->id,
                                'comment'   => $comment->id,
                            ]) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this comment?');"
                  >
                    @csrf
                    @method('DELETE')
                    <div class="delete-comment">
                      <button type="submit" class="delete-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" 
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             width="20" height="20">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21
                                   c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673
                                   a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077
                                   L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397
                                   m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397
                                   m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201
                                   a51.964 51.964 0 0 0-3.32 0
                                   c-1.18.037-2.09 1.022-2.09 2.201v.916
                                   m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                      </button>
                    </div>
                  </form>
                @endif
              </div>
          
        
          
            @endforeach
        </div>


 </div>


