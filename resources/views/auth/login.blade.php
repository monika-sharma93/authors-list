<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800  text-center">Login</h2>

        @if (session('error'))
            <p class="mt-2 text-red-600">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" value="{{config('services.api_username')}}" id="email" name="email" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200">
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="bl ock text-sm font-medium text-gray-700">Password</label>
                <input type="password" value="{{config('services.api_password')}}" id="password" name="password" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200">
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>

</body>
</html>
