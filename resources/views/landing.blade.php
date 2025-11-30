<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rondang Mulana - Sewa Alat Pesta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">Rondang Mulana</a>
            <div>
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('cart.index') }}"
                            class="relative text-gray-700 hover:text-blue-600 font-medium mr-6">
                            🛒 Keranjang
                            @if (session('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-2 -right-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ count((array) session('cart')) }}
                                </span>
                            @endif
                            <a href="{{ route('dashboard') }}"
                                class="text-gray-700 hover:text-blue-600 transition-colors duration-200"
                                title="Profil Pengguna">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M172,120a44,44,0,1,1-44-44A44.05,44.05,0,0,1,172,120Zm60,8A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88.09,88.09,0,0,0-91.47-87.93C77.43,41.89,39.87,81.12,40,128.25a87.65,87.65,0,0,0,22.24,58.16A79.71,79.71,0,0,1,84,165.1a4,4,0,0,1,4.83.32,59.83,59.83,0,0,0,78.28,0,4,4,0,0,1,4.83-.32,79.71,79.71,0,0,1,21.79,21.31A87.62,87.62,0,0,0,216,128Z">
                                    </path>
                                </svg>
                            </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium mr-4">Login</a>
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="bg-blue-600 text-white py-20 text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Wujudkan Pesta Impianmu</h1>
            <p class="text-lg md:text-xl mb-8 opacity-90">Sewa tenda, kursi, dan peralatan pesta lengkap dengan mudah.
            </p>
            <a href="#katalog"
                class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">Lihat
                Katalog</a>
        </div>
    </header>

    <main id="katalog" class="container mx-auto px-6 py-16">
        <div class="max-w-2xl mx-auto mb-10">
            <form action="{{ route('landing') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Cari tenda, kursi, atau panggung..."
                    value="{{ request('search') }}"
                    class="w-full border border-gray-300 p-3 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <button type="submit" class="bg-blue-600 text-white p-3 rounded-r-lg hover:bg-blue-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <h2 class="text-3xl font-bold text-center mb-12">Pilihan Alat Pesta</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            @forelse ($items as $item)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-56 bg-gray-200 overflow-hidden relative">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <span class="text-4xl">📷</span>
                            </div>
                        @endif
                        <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $item->category->name }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $item->description ?? 'Tidak ada deskripsi.' }}</p>

                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <span class="text-xs text-gray-500">Harga Sewa</span>
                                <p class="text-lg font-bold text-blue-600">Rp
                                    {{ number_format($item->price_per_day, 0, ',', '.') }} <span
                                        class="text-sm font-normal text-gray-500">/hari</span></p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block">Stok: {{ $item->stock }}</span>
                                <a href="{{ route('add_to_cart', $item->id) }}"
                                    class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                                    + Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada barang yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 text-center">
        <p>&copy; {{ date('Y') }} Rondang Mulana. All rights reserved.</p>
    </footer>

</body>

</html>
