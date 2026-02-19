{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en" x-data="setup()" x-init="
    document.documentElement.classList.toggle('dark', isDark);
    setColors(color);
  ">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Tawasul')</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-top.png') }}">

  <!-- Tailwind + Alpine -->

  <script src="https://cdn.tailwindcss.com"></script>

 



 

</head>
<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-[#373e57] text-gray-900 dark:text-white">

  {{-- logo --}}
  
    {{-- <div class="flex-grow max-w-md w-full mx-auto px-4 py-8">
      <a href="/" class="flex items-center">
        <img
          src="/images/logo.png"
          alt="Tawasul Logo"
          class=""
        />
        
      </a>
    </div>
  --}}
  

  {{-- Main Content --}}
 
    
  <div class="max-w-xs w-full mx-auto py-4 px-2 max-h-56">
    <img
      src="/images/logo.png"
      alt="Tawasul Logo"
      class="h-auto w-full object-contain"
    />
  </div>
  
 
    @yield('content')
  

 


</body>
</html>
