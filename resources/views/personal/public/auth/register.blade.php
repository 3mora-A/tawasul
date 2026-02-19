@extends('personal.public.auth.start')

@section('title', 'Register')

@section('content')
<main class="flex items-center justify-center">
  <div class="w-full max-w-md space-y-8">

    {{-- Card --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg space-y-6">
      <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        Create your account
      </h2>

      {{-- Flash & Validation Messages --}}
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

      {{-- Form --}}
      <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="rounded-md shadow-sm space-y-4">
          <div>
            <label for="username" class="sr-only">Username</label>
            <input
              id="username"
              name="username"
              type="text"
              required
              placeholder="Username"
              class="appearance-none rounded-md block w-full px-3 py-2 border
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input
              id="email"
              name="email"
              type="email"
              required
              placeholder="Email address"
              class="appearance-none rounded-md block w-full px-3 py-2 border
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
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
              class="appearance-none rounded-md block w-full px-3 py-2 border
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>
          <div>
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              required
              placeholder="Confirm Password"
              class="appearance-none rounded-md block w-full px-3 py-2 border
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            />
          </div>

          {{-- Faculty Select --}}
          @php
            $facultyGroups = \App\Models\User::facultyOptions();
          @endphp
          <div>
            <label for="faculty" class="sr-only">Faculty</label>
            <select
              id="faculty"
              name="faculty"
              required
              class="appearance-none rounded-md block w-full px-3 py-2 border
                     border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700
                     text-gray-900 dark:text-gray-100 placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
            >
              <option value="">Select Faculty</option>
              @foreach($facultyGroups as $group => $faculties)
                <optgroup label="{{ $group }}">
                  @foreach($faculties as $code => $label)
                    <option value="{{ $code }}">{{ $label }}</option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Terms --}}
        <div class="flex items-center">
          <input
            id="accept_terms"
            name="accept_terms"
            type="checkbox"
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
          />
          <label for="accept_terms" class="ml-2 block text-sm text-gray-600 dark:text-gray-400">
            I accept the
            <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms &amp; Conditions</a>
          </label>
        </div>

        {{-- Submit --}}
        <div>
          <button
            type="submit"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent
                   text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Register
          </button>
        </div>
      </form>

      {{-- OR separator --}}
      <div class="mt-6 flex items-center justify-center">
        <div class="w-1/5 border-t border-gray-300 dark:border-gray-600"></div>
        <span class="px-4 text-gray-500 dark:text-gray-400">OR</span>
        <div class="w-1/5 border-t border-gray-300 dark:border-gray-600"></div>
      </div>

      {{-- Social Login --}}
      <div class="space-y-4">
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

      {{-- Already have an account? --}}
      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
          Sign in
        </a>
      </p>
    </div>
  </div>
</main>
@endsection
