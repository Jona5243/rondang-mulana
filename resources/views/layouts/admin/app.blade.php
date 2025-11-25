<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-800 text-white p-4">
            <h1 class="text-2xl font-bold mb-4">Rondang Mulana</h1>
            <nav>
                <ul>
                    <li class="mb-2">
                        <a href="#" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.categories.index') }}"
                            class="block p-2 rounded bg-gray-900">Kategori</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.items.index') }}" class="block p-2 rounded hover:bg-gray-700">Barang (Items)</a>
                    </li>
                    <li class="mt-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block p-2 rounded hover:bg-red-700">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            <h2 class="text-3xl font-bold mb-6">
                @yield('title')
            </h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')

        </main>
    </div>
</body>

</html>
