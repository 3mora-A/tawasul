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
  <link rel="stylesheet" href="/css/profile.css">
  <link rel="stylesheet" href="/css/right-side.css">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-top.png') }}">

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
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="snippet-body bg-gray-100 dark:bg-[#373e57] text-gray-900 dark:text-white">
  <div class="container flex">
    {{-- Left sidebar --}}
    <div class="left-side">
      @include('components.left-side')
    </div>

    {{-- Main content --}}
    <div class="main">
      <div class="main-container">
        @yield('content')
      </div>
    </div>

    {{-- Right sidebar --}}
    @include('components.right-side')
  </div>
</body>
</html>
