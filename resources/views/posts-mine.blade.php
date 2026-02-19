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
  {{-- <style>
    div{
      background-color: #121212 !important; /* Dark background */
      color: #ffffff !important; /* White text for all body elements */
    }

    a, h1, h4, p ,span{
      color: #ffffff !important; /* White text for links, h1, h4, p, and main */
    }

    /* Optional: Remove text decoration for links */
    a {
      text-decoration: none;
    }

    /* Make background of .bg-white class dark */
    .bg-white {
      background-color: #121212 !important; /* Dark background */
      color: #ffffff !important; /* White text */
    }
  </style> --}}
  <div class="container" x-data="{ rightSide: false, leftSide: false }">
    
      @include('components.left-side')
   

    <div class="main"> <!-- ✅ هذه تشمل المحتوى والجهة اليمنى -->
      <div class="main-container">
        <h4 class="post-heading">Post Something</h4>
        @include('partials.post-form')
    
        <h4 class="post-heading">Explore</h4>
    
        @foreach ($posts as $post)
            @include('partials.single-post', ['post' => $post])
        @endforeach
      </div>
    
      
    </div>
     <!-- ⬅️ إغلاق صحيح لـ main -->
   
      @include('components.right-side')
   
  </div> <!-- ⬅️ إغلاق صحيح لـ container -->


</body>
</html>
