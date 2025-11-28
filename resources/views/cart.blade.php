<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Rondang Mulana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold mb-6">Keranjang Belanja Anda</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            @if (session('cart') && count(session('cart')) > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th
                                class="py-4 px-6 bg-gray-100 font-bold font-uppercase text-sm text-gray-600 border-b border-gray-200">
                                Produk</th>
                            <th
                                class="py-4 px-6 bg-gray-100 font-bold font-uppercase text-sm text-gray-600 border-b border-gray-200">
                                Harga</th>
                            <th
                                class="py-4 px-6 bg-gray-100 font-bold font-uppercase text-sm text-gray-600 border-b border-gray-200">
                                Jumlah</th>
                            <th
                                class="py-4 px-6 bg-gray-100 font-bold font-uppercase text-sm text-gray-600 border-b border-gray-200">
                                Subtotal</th>
                            <th
                                class="py-4 px-6 bg-gray-100 font-bold font-uppercase text-sm text-gray-600 border-b border-gray-200">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach (session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 border-b border-gray-200 flex items-center">
                                    {{-- Cek gambar --}}
                                    @if ($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}"
                                            alt="{{ $details['name'] }}" class="w-12 h-12 object-cover rounded mr-4">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-gray-200 rounded mr-4 flex items-center justify-center">
                                            📷</div>
                                    @endif
                                    <span class="font-medium">{{ $details['name'] }}</span>
                                </td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    {{ $details['quantity'] }}
                                </td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    <form action="{{ route('remove_from_cart') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button class="text-red-500 hover:text-red-700 text-sm font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right py-6">
                                <h3 class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">
                                <a href="{{ url('/') }}"
                                    class="bg-gray-500 text-white font-bold py-2 px-4 rounded mr-2 hover:bg-gray-600">
                                    Lanjut Belanja
                                </a>
                                <a href="{{ route('checkout') }}"
                                    class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
                                    Checkout / Bayar
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg mb-4">Keranjang belanja Anda kosong.</p>
                    <a href="{{ url('/') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold hover:bg-blue-700">
                        Mulai Sewa Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
