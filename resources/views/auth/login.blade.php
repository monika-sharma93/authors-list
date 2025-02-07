<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-gray-800">Login</h2>

        @if (session('error'))
            <p class="mt-2 text-red-600">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Login with API
            </button>
        </form>
    </div>

</body>
</html>
