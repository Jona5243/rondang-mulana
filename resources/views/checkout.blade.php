<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Rondang Mulana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Formulir Penyewaan</h1>

        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tanggal Mulai Sewa</label>
                    <input type="date" name="start_date" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tanggal Selesai Sewa</label>
                    <input type="date" name="end_date" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Alamat Lengkap Pengiriman/Acara</label>
                    <textarea name="address" rows="4" class="w-full border rounded px-3 py-2"
                        placeholder="Jl. Mawar No. 123, Medan..." required></textarea>
                </div>

                <div class="bg-blue-50 p-4 rounded mb-6">
                    <p class="text-sm text-blue-800">
                        Total Barang: <strong>{{ count(session('cart')) }} item</strong><br>
                        <span class="text-xs">Total harga akan dihitung otomatis berdasarkan jumlah hari sewa.</span>
                    </p>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                    Konfirmasi Pesanan
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('cart.index') }}" class="text-gray-500 text-sm hover:underline">Kembali ke
                    Keranjang</a>
            </div>
        </div>
    </div>

</body>

</html>
