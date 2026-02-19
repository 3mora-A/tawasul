@extends('personal.public.auth.start')
@section('title', 'Request Password')

@section('content')
<main class="flex items-center justify-center">
  <div class="w-full max-w-md space-y-8">
    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg space-y-6">
      <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        Forgot your password?
      </h2>
      <p class="text-center text-sm text-gray-600 dark:text-gray-400">
        Enter your email below and we'll send you a link to reset it.
      </p>

      {{-- Alerts --}}
      @if(session('status'))
        <div class="text-green-800 bg-green-100 px-4 py-2 rounded">
          {{ session('status') }}
        </div>
      @endif
      @if(session('error'))
        <div class="text-red-800 bg-red-100 px-4 py-2 rounded">
          {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div class="text-red-800 bg-red-100 px-4 py-2 rounded">
          <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form -->
      <form action="{{ route('reset-password-link') }}" method="POST" class="space-y-6">
        @csrf
        <div>
          <label for="email" class="sr-only">Email address</label>
          <input
            id="email"
            name="email"
            type="email"
            required
            placeholder="Email address"
            class="
              appearance-none rounded-md block w-full px-3 py-2 border
              border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
              text-gray-900 dark:text-gray-100 placeholder-gray-500
              focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
            "
          />
        </div>
        <div>
          <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent
                   text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Request reset link
          </button>
        </div>
      </form>

      <!-- Back to reset password form if they already have a link -->
      <p class="text-center text-sm text-gray-600 dark:text-gray-400">
        Remembered your password?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
          Sign in
        </a>
      </p>
      <p class="text-center text-sm text-gray-600 dark:text-gray-400">
        Already have a password? 
        <a href="{{ route('reset-old-password') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
          Reset
        </a>
      </p>
    
    
      
      
    </div>
  </div>
</main>
@endsection
