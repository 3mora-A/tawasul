@extends('personal.public.auth.start')
@section('title', 'Reset Password')

@section('content')
<main class="flex items-center justify-center">
  <div class="w-full max-w-md space-y-8">
    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
      <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        Reset Your Password
      </h2>

      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
        You’re one step away from a new password. Enter it below to recover access.
      </p>

      {{-- Alerts --}}
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
      <form action="{{ route('reset-password-form', ['token' => $token]) }}"
            method="POST"
            class="mt-8 space-y-6"
      >
        @csrf

        <!-- Hidden fields -->
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="rounded-md shadow-sm space-y-4">
          <!-- Email (readonly) -->
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input
              id="email"
              name="email"
              type="email"
              value="{{ $email }}"
              readonly
              class="appearance-none rounded-md block w-full px-3 py-2 border 
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>
          <!-- New Password -->
          <div>
            <label for="new_password" class="sr-only">New Password</label>
            <input
              id="new_password"
              name="new_password"
              type="password"
              required
              placeholder="New Password"
              class="appearance-none rounded-md block w-full px-3 py-2 border 
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>
          <!-- Confirm Password -->
          <div>
            <label for="new_password_confirmation" class="sr-only">Confirm Password</label>
            <input
              id="new_password_confirmation"
              name="new_password_confirmation"
              type="password"
              required
              placeholder="Confirm Password"
              class="appearance-none rounded-md block w-full px-3 py-2 border 
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent
                   text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Reset Password
          </button>
        </div>
      </form>

      <!-- Back to login -->
      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Remembered your password?
        <a href="{{ route('login') }}"
           class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          Sign in
        </a>
      </p>
    </div>
  </div>
</main>
@endsection
