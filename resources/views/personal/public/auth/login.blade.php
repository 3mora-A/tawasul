

@extends('personal.public.auth.start')

@section('title', 'Login')

@section('content')
  <main class="flex items-center justify-center ">
    <div class="w-full max-w-md space-y-8">
      <!-- Card -->
      <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
          Sign in to your account
        </h2>

        <!-- Alerts -->
        @if(session('status'))
        <div class="mt-4 text-green-800 bg-green-100 px-4 py-2 rounded">
          {{ session('status') }}
        </div>
      @endif
      @if(session('error'))
        <div class="mt-4 text-red-800 bg-red-100 px-4 py-2 rounded">
          {{ session('error') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="mt-4 text-red-800 bg-red-100 px-4 py-2 rounded">
          <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form -->
      <form action="{{ url('/login') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        <div class="rounded-md shadow-sm space-y-4">
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input
              id="email"
              name="email"
              type="email"
              required
              placeholder="Email address"
              class="appearance-none rounded-md relative block w-full px-3 py-2 border 
                    border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                    text-gray-900 dark:text-gray-100 placeholder-gray-500 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 
                    focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              placeholder="Password"
              class="appearance-none rounded-md relative block w-full px-3 py-2 border 
                    border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                    text-gray-900 dark:text-gray-100 placeholder-gray-500 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 
                    focus:border-indigo-500"
            />
          </div>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center text-sm text-gray-600 dark:text-gray-400">
            <input
              type="checkbox"
              name="remember_me"
              class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            />
            <span class="ml-2">Remember me</span>
          </label>

          <div class="text-sm">
            <a href="{{ route('reset-password-link') }}"
              class="font-medium text-indigo-600 hover:text-indigo-500">
              Forgot your password?
            </a>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                  text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Sign In
          </button>
        </div>
      </form>

      <!-- OR separator -->
      <div class="mt-6 flex items-center justify-center">
        <div class="w-1/5 border-t border-gray-300 dark:border-gray-600"></div>
        <div class="px-4 text-gray-500 dark:text-gray-400">OR</div>
        <div class="w-1/5 border-t border-gray-300 dark:border-gray-600"></div>
      </div>

      <!-- Social Login -->
      <div class="mt-6 space-y-4">
        <a
        href="/auth/google"
        class="
          w-full flex items-center justify-center
          px-4 py-2
          bg-black hover:
          text-white font-medium rounded-md shadow
          transition-colors duration-200
        "
      >
        <!-- Google “G” icon SVG -->
        <svg
          class="w-5 h-5 mr-2"
          viewBox="0 0 533.5 544.3"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path fill="#fff" d="M533.5 278.4c0-17.8-1.6-35.2-4.7-52.4H272v99.2h146.9c-6.4 34.7-25 64.1-53.3 83.8v69.7h86.1c50.4-46.4 81.8-114.9 81.8-199.8z"/>
          <path fill="#fff" d="M272 544.3c72.9 0 134.1-24.1 178.8-65.4l-86.1-69.7c-24 16.1-54.8 25.6-92.7 25.6-71 0-131.2-47.9-152.7-112.2H31.6v70.6c44.8 89.3 136.5 151.1 240.4 151.1z"/>
          <path fill="#fff" d="M119.3 324.6c-10.8-32.3-10.8-66.6 0-98.9v-70.6H31.6c-44.3 88.5-44.3 193.5 0 282l87.7-70.5z"/>
          <path fill="#fff" d="M272 107.7c39.8.6 77.8 14 106.8 38.6l80.4-80.4C404.7 24 345.8 0 272 0 168.1 0 76.4 61.8 31.6 151.1l87.7 70.6C140.8 155.6 201 107.7 272 107.7z"/>
        </svg>
      
        <span>Sign in with Google</span>
      </a>
      

      </div>

      <!-- Register -->
      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Don’t have an account? 
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
          Register
        </a>
      </p>
    </div>
    </div>
  </main>
@endsection
