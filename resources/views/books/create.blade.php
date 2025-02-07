@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Add New Book</h2>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <strong>There were some issues with your submission:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-semibold">Title</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
            </div>

            <!-- Release Date -->
            <div>
                <label class="block text-gray-700 font-semibold">Release Date</label>
                <input type="datetime-local" name="release_date" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
            </div>

            <!-- ISBN -->
            <div>
                <label class="block text-gray-700 font-semibold">ISBN</label>
                <input type="text" name="isbn" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
            </div>

            <!-- Format -->
            <div>
                <label class="block text-gray-700 font-semibold">Format</label>
                <select name="format" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
                    <option value="hardcover">Hardcover</option>
                    <option value="paperback">Paperback</option>
                    <option value="ebook">E-Book</option>
                </select>
            </div>

            <!-- Number of Pages -->
            <div>
                <label class="block text-gray-700 font-semibold">Number of Pages</label>
                <input type="number" name="number_of_pages" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
            </div>

            <!-- Author Dropdown -->
            <div>
                <label class="block text-gray-700 font-semibold">Author</label>
                <select name="author" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
                    <option value="">Select an Author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Description (Full Width) -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-gray-700 font-semibold">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500" rows="4"></textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-end">
        
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Add Book
            </button>
        </div>
    </form>
</div>
@endsection
