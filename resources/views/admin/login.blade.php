

@extends('personal.public.auth.start')

@section('title', 'Login')

@section('content')
  <main class="flex items-center justify-center ">
    <div class="w-full max-w-md space-y-8">
      <!-- Card -->
      <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
Admin Sign In      
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
    
      <form method="POST" action="{{ route('admin.login') }}" class="mt-8 space-y-6">
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
