<div class="right-side">


    <div class="account">
        <button class="account-button">
            <svg stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1" viewBox="0 0 24 24">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <path d="M22 6l-10 7L2 6" />
            </svg>
        </button>
        <button class="account-button">
            <svg stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
            </svg>
        </button>
        @php
            $user = Auth::user();
        @endphp

        

    
    <a href="{{ route('profile-mine') }}" class="account-user flex items-center gap-2 cursor-pointer">
        {{ $user->username }}
        <img 
            src="{{ Str::startsWith($user->profile_picture, ['http://', 'https://']) 
                ? $user->profile_picture 
                : ($user->profile_picture 
                    ? asset('storage/' . $user->profile_picture) 
                    : asset('images/default_profile.png')) }}" 
            alt="Profile Picture" 
            class="user-img"
        >
    </a>
    </div>

    <div class="side-wrapper stories">
        <div class="side-title">Suggested</div>

        @php
            $myFaculty = Auth::user()->faculty;
        @endphp

        @foreach ($suggestedUsers->where('faculty', $myFaculty) as $user)
            <a href="{{ route('profile.public', $user->id) }}" style="text-decoration: none; color: inherit;">
                <div class="user" style="cursor: pointer;">
                    <img 
                        src="{{ Str::startsWith($user->profile_picture, ['http://', 'https://']) 
                            ? $user->profile_picture 
                            : ($user->profile_picture 
                                ? asset('storage/' . $user->profile_picture) 
                                : asset('images/default_profile.png')) }}" 
                        alt="Profile Picture" 
                        class="user-img"
                    >
                    <div class="username">
                        {{ $user->username }}
                        <div class="album-date">Active recently</div>
                    </div>
                </div>
            </a>
        @endforeach


        
    </div>

    <div class="side-wrapper stories">
        <div class="side-title">Search Users</div>
      
        <!-- Results container: will scroll if it grows -->
        <div id="searchResults" class="search-results"></div>
      
        <!-- Search bar pinned to bottom -->
        <div class="search-bar">
          <form id="userSearchForm" autocomplete="off">
            <div class="search-input-wrapper">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="size-6 search-icon"
                >
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                  type="text"
                  id="userSearchInput"
                  name="query"
                  placeholder="Type at least 2 characters…"
                  class="search-input"
                  oninput="onSearchInput(this.value)"
                />
              </div>
              
              
          </form>
        </div>
      </div>
      
  
    </form>
  </div>
</div>


</div>



<script>
document.addEventListener('DOMContentLoaded', () => {
  const input      = document.getElementById('userSearchInput');
  const resultsBox = document.getElementById('searchResults');

  input.addEventListener('input', () => {
    const q = input.value.trim();
    if (q.length < 2) {
      resultsBox.innerHTML = '';
      return;
    }

    fetch(`/search-users?query=${encodeURIComponent(q)}`)
      .then(r => r.json())
      .then(users => {
        resultsBox.innerHTML = users.length
          ? users.map(u => `
              <a href="/user/${u.id}" class="result-item">
                <img src="${
                  u.profile_picture
                    ? (u.profile_picture.startsWith('http')
                        ? u.profile_picture
                        : `/storage/${u.profile_picture}`)
                    : '/images/default_profile.png'
                }" alt="${u.username}">
                <span>${u.username}</span>
              </a>
            `).join('')
          : `<div class="result-item" style="justify-content:center;color:gray;">
               No users found.
             </div>`;
      })
      .catch(console.error);
  });
});

</script>

