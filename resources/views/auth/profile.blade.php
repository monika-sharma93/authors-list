@extends('layouts.app')
@section('content')

    <div class="w-full max-w-4xl p-6 bg-white shadow-lg rounded-lg">
    <div class="bg-white text-black p-6 rounded-lg  w-96">
        <h2 class="text-2xl font-bold mb-4">User Profile</h2>
        
        <div class="mb-2">
            <strong>Name:</strong> <span>{{ session('user.first_name') }} {{ session('user.last_name') }}</span>
        </div>
        <div class="mb-2">
            <strong>Email:</strong> <span>{{ session('user.email') }}</span>
        </div>
        <div class="mb-2">
            <strong>Gender:</strong> <span>{{ ucwords(session('user.gender')) ?? 'Not provided' }}</span>
        </div>

    </div>
    </div>
@endsection
