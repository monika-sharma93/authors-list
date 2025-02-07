@extends('layouts.app')
@section('content')

    <div class="w-full max-w-4xl p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Authors List</h2>

        @if (session('error'))
            <p class="text-red-600 text-center">{{ session('error') }}</p>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Birthday</th>
                    <th class="border border-gray-300 px-4 py-2">Gender</th>
                    <th class="border border-gray-300 px-4 py-2">Place Of Birth</th>
                    <th class="border border-gray-300 px-4 py-2">Books</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $author['id'] }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $author['first_name'] }} {{ $author['last_name'] }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ \Carbon\Carbon::parse($author['birthday'])->format('d M Y')  }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ ucwords($author['gender']) }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ ucwords($author['place_of_birth']) }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $author['books_count'] }}</td>

                        <td class="border border-gray-300 px-4 py-2 text-center">
                        <a href="{{route('authors.show', $author['id']) }}" class="bg-blue-500 text-white px-3 py-1 mr-2 rounded hover:bg-blue-600">
                            View
                        </a>
                        @if(empty($author['books_count']))
                        <!-- Delete Button -->
                        <form action="{{ url('/authors/' . $author['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this author?');">
                                Delete
                            </button>
                        </form>
                        @endif
                        
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                            No authors found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
