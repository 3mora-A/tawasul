<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Tawasul</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-top.png') }}">

    <link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">
    @vite(['resources/js/app.js'])
    </head>
    
      

    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
  <!-- ***** Header Area Start ***** -->
<header class="bg-white fixed inset-x-0 top-0 z-50 shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="#" class="text-2xl font-bold text-gray-800">Tawasul</a>

      <!-- Desktop Nav -->
      <ul class="hidden md:flex space-x-8">
       
        <li>
            <a
  href="{{ route('login') }}"
  class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition"
>
  Login
</a>

            
            </a>
          </li>
                </ul>

      <!-- Mobile Menu Button -->
      <button
        class="md:hidden flex flex-col justify-between w-6 h-6 focus:outline-none"
        aria-label="Toggle Menu"
        onclick="document.querySelector('.nav-mobile').classList.toggle('hidden')"
      >
        <span class="block w-full h-0.5 bg-gray-800"></span>
        <span class="block w-full h-0.5 bg-gray-800"></span>
        <span class="block w-full h-0.5 bg-gray-800"></span>
      </button>
    </nav>
  </div>

  <!-- Mobile Nav -->
  <ul class="nav-mobile hidden md:hidden bg-white shadow-md">
    <li><a href="#welcome" class="block px-4 py-3 text-gray-700 hover:bg-pink-50">Home</a></li>
    <li><a href="#features" class="block px-4 py-3 text-gray-700 hover:bg-pink-50">About</a></li>
    <li><a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-pink-50">Login</a></li>
  </ul>
</header>


    <!-- ***** Header Area End ***** -->

    <!-- ***** Welcome Area Start ***** -->
    <div class="welcome-area" id="welcome">

        <!-- ***** Header Text Start ***** -->
        <div class="header-text">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-sm-12">
                        <h1>Welcome to <strong>Tawasul</strong><br> A space for everyone, from every faculty.</h1>
                        <p>Join communities, post your thoughts, connect with others — and truly belong..</p>
                        <a href="#features" class="main-button-slider">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** Header Text End ***** -->
    </div>
 

    <!-- ***** Features Big Item Start ***** -->
    <section class="section padding-top-70 padding-bottom-0" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 align-self-center" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <img src="assets/images/left-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-top-fix">
                    <div class="left-heading">
                        <h2 class="section-title">Let’s talk about your world</h2>
                    </div>
                    <div class="left-text">
                        <p>Tawasul isn’t just a platform — it’s your community.
Join meaningful conversations, share what matters to you, and explore voices from across every faculty.
Connect freely. Express yourself openly. Truly belong.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-bottom-fix">
                    <div class="left-heading">
                        <h2 class="section-title">Grow your presence, not just your profile
                        </h2>
                    </div>
                    <div class="left-text">
                        <p>Tawasul lets you share ideas, stay active, and connect with students from your faculty and beyond — even across universities.</p>
                    </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-5 col-md-12 col-sm-12 align-self-center mobile-bottom-fix-big" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                    <img src="assets/images/right-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

  
            </div>
        </div>
    </section>
    <!-- ***** Home Parallax End ***** -->

 
    
   

    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright">Copyright &copy; 2025 Tawasul - Developed by Team جذور</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

  </body>
</html>