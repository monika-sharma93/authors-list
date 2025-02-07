<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar + Content Wrapper -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white p-5 flex flex-col">
            <!-- Logo -->
            <div class="mb-8 flex justify-center">
                Logo
            </div>

            <!-- Navigation -->
            <nav class="flex-1">
                <ul>
                    <li class="mb-2">
                        <a href="{{ url('/profile') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Profile</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('books.create') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Create Book</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/authors') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Authors</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('logout') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Logout</a>

                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-4">
                <div class="container mx-auto flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-700">Dashboard</h1>
                    <span class="text-gray-600">{{ (session('user.first_name') .' '. session('user.last_name')) ?? 'Guest' }}</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 flex-1">
                @if (session('success'))
                    <div id="success-message" class="bg-green-500 text-white p-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>

                    <script>
                        setTimeout(function() {
                            document.getElementById('success-message').style.display = 'none';
                        }, 3000);
                    </script>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
