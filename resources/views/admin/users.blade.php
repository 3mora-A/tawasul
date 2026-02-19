{{-- resources/views/admin/users.blade.php --}}
@extends('admin.dashboard')

@section('title','Users')

@section('content')
<div class="main-content bg-white text-gray-900 min-h-screen p-6">
    <div class="max-w-7xl">
        <h2 class="text-2xl font-bold mb-6">User Management</h2>

        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800">
                {{ session('error') }}
            </div>
        @endif

            <table class="min-w-full bg-white border border-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $user->id }}</td>
                        <td class="px-4 py-3">{{ $user->username }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                                {{ $user->banned_at ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                {{ $user->banned_at ? 'Banned' : 'Active' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            + <a href="{{ route('profile.public', ['user' => $user->id]) }}" …
                                class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700">
                                View
                            </a>

                            

                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-block px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection
