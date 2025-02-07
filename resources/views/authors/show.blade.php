@extends('layouts.app')
@section('content')

        @if (session('error'))
            <p class="text-red-600 text-center">{{ session('error') }}</p>
        @endif


        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
            
            <h2 class="text-2xl font-semibold mb-4">Author Details</h2>

            <div class="border-b pb-3 mb-3">
                <p><strong>ID:</strong> {{ $author['id'] }}</p>
                <p><strong>Name:</strong> {{ $author['first_name'] }} {{ $author['last_name'] }}</p>
                <p><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($author['birthday'])->format('d M Y') }}</p>
                <p><strong>Gender:</strong> {{ ucwords($author['gender']) }}</p>
                <p><strong>Place Of Birth:</strong> {{ ucwords($author['place_of_birth']) }}</p>
            </div>

            <!-- Books Section -->
            <h3 class="text-xl font-semibold mb-2">Books</h3>
            @if (!empty($author['books']))
                <table class="min-w-full border border-gray-300 shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 border-b">Book ID</th>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Release Date</th>
                            <th class="py-2 px-4 border-b">Number Of Pages</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($author['books'] as $book)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b text-center">{{ $book['id'] }}</td>
                            <td class="py-2 px-4 border-b">{{ $book['title'] }}</td>
                            <td class="py-2 px-4 border-b">{{ $book['description'] }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ \Carbon\Carbon::parse($book['release_date'])->format('d M Y')  }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $book['number_of_pages'] }}</td>

                            <td class="py-2 px-4 border-b text-center">
                                <!-- Delete Book Button -->
                                <form action="{{ url('/books/' . $book['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Are you sure you want to delete this book?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No books found for this author.</p>
            @endif

            <a href="{{ url('/authors') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Back to Authors
            </a>
        </div>

    </div>
@endsection
