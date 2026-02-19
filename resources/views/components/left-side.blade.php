
<div class="left-side">

<div class="left-side-button" @click="leftSide = !leftSide">
    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
    <svg stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <path d="M19 12H5M12 19l-7-7 7-7" />
    </svg>
</div>
<div
  class="logo-image"
>
  <img
    src="/images/logo.png"
    alt="Tawasul Logo"
    class="logo-image"
  />
</div>

  
{{-- <div class="logo">Tawasul</div> --}}

<div class="side-wrapper-left  ">
    {{-- <div class="side-title">MENU</div> --}}
    <div class="side-menu">
        <a href="{{ route('posts-mine') }}"
        class="d-flex align-items-center text-decoration-none mb-2 {{ request()->routeIs('posts-mine') ? 'active' : 'text-dark' }}">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                 viewBox="0 0 24 24" style="width: 20px; height: 20px;" class="me-2">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <path d="M9 22V12h6v10" />
            </svg>
           Public
        </a>
    
        @php
            // Get the authenticated user’s faculty code (null if none)
            $facultyCode = Auth::check() ? Auth::user()->faculty : null;
        @endphp

    
        
    @php
    $facultyCode    = Auth::check() ? Auth::user()->faculty : null;
    $onFacultyPage  = request()->routeIs('faculty.index');
  @endphp
  
  <a
    href="{{ $facultyCode
              ? route('faculty.index', ['faculty' => $facultyCode])
              : '#' }}"
    @if(! $facultyCode)
      onclick="event.preventDefault();
               alert('You must choose a faculty first.');
               window.location='{{ route('profile-mine') }}';"
    @endif
    class="
      
            d-flex align-items-center text-decoration-none mb-2
            text-dark
        
      {{ $facultyCode     ? '' : 'side-nav__link--disabled' }}
      {{ $onFacultyPage   ? 'side-nav__link--active'   : '' }}
    "
  >
  <svg xmlns="http://www.w3.org/2000/svg"
  fill="none" stroke="currentColor" stroke-width="2"
  stroke-linecap="round" stroke-linejoin="round"
  viewBox="0 0 24 24"
  style="width: 20px; height: 20px;"
  class="me-2">
 <path d="M12 14l9-5-9-5-9 5 9 5z" />
 <path d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.75 12.08 12.08 0 015.84 10.578L12 14z" />
 <path d="M12 14v7.5" />
</svg>
    <span>Faculty</span>
  </a>
  
  



    
    <a 
    href="{{ route('communities.index') }}" 
    class="d-flex align-items-center text-decoration-none mb-2 {{ request()->routeIs('communities.*') ? 'active' : 'text-dark' }}"
    >
    <svg 
        stroke="currentColor" 
        stroke-width="2" 
        fill="none" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        viewBox="0 0 24 24" 
        style="width: 20px; height: 20px;" 
        class="me-2"
    >
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
    </svg>
    Community
    </a>

    
        <a href="{{ route('profile-mine') }}"
        class="d-flex align-items-center text-decoration-none mb-2 {{ request()->routeIs('profile-mine') ? 'active' : 'text-dark' }}">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                 style="width: 24px; height: 24px;" class="me-2">
                <path d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            Profile
        </a>

       
   

        <a href="#" class="d-flex align-items-center text-decoration-none text-dark mb-2" onclick="handleLogout()" style="cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                 viewBox="0 0 24 24" style="width: 20px; height: 20px;" class="me-2">
                <path d="m16 17 5-5-5-5" />
                <path d="M21 12H9" />
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            </svg>
            Logout
        </a>
          
    </div>

    
    
</div>


</div>
<script>
    function handleLogout() {
        // إنشاء فورم وهمي لإرسال طلب POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("logout") }}';
    
        // إضافة توكن CSRF
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
    
        form.appendChild(token);
    
        document.body.appendChild(form);
        form.submit();
    }
    </script>
    
<style>



.side-menu {
  display: flex;
  flex-direction: column;
  font-size: 15px;
  white-space: nowrap;
}

.side-menu svg {
  margin-right: 16px;
  width: 16px;
}

.side-menu a {
  text-decoration: none;
  color: #9c9cab;
  display: flex;
  align-items: center;
}

.side-menu a:hover {
  color: #fff;
}

.side-menu a:not(:last-child) {
  margin-bottom: 20px;
}

.side-menu a.active {
  color: #0d6efd; /* or any highlight color */
  font-weight: bold;
}


.side-wrapper-left {
  display: flex;             /* establish flex context */
  flex-direction: column;    /* stack children top → bottom */
  justify-content: center;   /* center vertically */
  padding: 2rem;             /* ~30px */
  position: relative;       
  
  top: -8rem;                /* move down by 10rem (≈160px) */
  box-sizing: border-box;    /* include padding in width calculations */


  margin-top: 10px
}
.logo-image {
  position: relative;       /* “relative” */
  top: -1.5rem;              /* tailwind’s top-10 (10×0.25rem) moves it down 2.5rem */
  max-width: 12rem;         /* max-w-[12rem] */
  width: 100%;              /* w-full */
  margin: 0 auto;           /* mx-auto */
  padding: 0.5rem 0.25rem;  /* py-2 (0.5rem top/bottom), px-1 (0.25rem left/right) */
  box-sizing: border-box;   /* ensure padding is included in the width */
}



/* base link style */
.side-nav__link {
  display: flex;
  align-items: center;
  margin-bottom: .5rem;
  color: #4A5568;             /* text-gray-700 */
  text-decoration: none;
  transition: color .2s;
  cursor: pointer;
}
.side-nav__link svg {
  margin-right: .5rem;
  stroke: currentColor;
}
.side-nav__link:hover {
  color: #3B82F6;             /* blue-500 */
}

/* disabled look */
.side-nav__link--disabled {
  color: #A0AEC0;             /* text-gray-400 */
  cursor: not-allowed;
}
.side-nav__link--disabled:hover {
  color: #A0AEC0;
}

/* “active” state */
.side-nav__link--active {
  color: #3B82F6;             /* blue-500 */
  font-weight: 600;
}

.side-menu a.side-nav__link--active {
    color: #3B82F6;
    font-weight: 600;
}

.side-nav__link--active {
    color: #3B82F6 !important;
}
</style>