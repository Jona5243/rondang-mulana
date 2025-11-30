@extends('layouts.admin.app')
@section('title', 'Detail Pesanan #' . $rental->id)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-bold text-gray-800">Informasi Penyewa</h3>

                <span
                    class="px-3 py-1 rounded-full text-xs font-bold 
                {{ $rental->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $rental->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                {{ $rental->status == 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                {{ $rental->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ strtoupper($rental->status) }}
                </span>
            </div>

            <div class="space-y-3 text-sm">
                <p><span class="text-gray-500 block">Nama Penyewa:</span> {{ $rental->user->name }}</p>
                <p><span class="text-gray-500 block">Email:</span> {{ $rental->user->email }}</p>
                <p><span class="text-gray-500 block">Tanggal Sewa:</span>
                    <span class="font-semibold">{{ date('d M Y', strtotime($rental->start_date)) }}</span>
                    s/d
                    <span class="font-semibold">{{ date('d M Y', strtotime($rental->end_date)) }}</span>
                </p>
                <p><span class="text-gray-500 block">Alamat Pengiriman:</span> {{ $rental->address }}</p>
            </div>

            <div class="mt-6 p-4 bg-gray-50 rounded border border-gray-200">
                <p class="text-sm text-gray-500">Total Biaya:</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Barang Disewa</h3>
            <div class="overflow-y-auto max-h-[300px]">
                <ul class="divide-y divide-gray-200">
                    @foreach ($rental->items as $detail)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center">
                                @if ($detail->item->image)
                                    <img src="{{ asset('storage/' . $detail->item->image) }}"
                                        class="w-12 h-12 rounded object-cover mr-3 border">
                                @else
                                    <div
                                        class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center text-xs">
                                        No Pic</div>
                                @endif

                                <div>
                                    <p class="font-medium text-gray-800">{{ $detail->item->name }}</p>
                                    <p class="text-xs text-gray-500">Rp
                                        {{ number_format($detail->price_per_day, 0, ',', '.') }} / hari</p>
                                </div>
                            </div>
                            <span class="font-bold bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">x
                                {{ $detail->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div
            class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="flex gap-2">
                <a href="{{ route('admin.rentals.index') }}"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2 border rounded hover:bg-gray-50 transition">
                    ← Kembali
                </a>

                @if ($rental->status == 'completed')
                    <a href="{{ route('admin.rentals.print', $rental->id) }}" target="_blank"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded flex items-center gap-2 transition shadow">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                            <path d="M6 14h12v8H6z" />
                        </svg>
                        Cetak Invoice
                    </a>
                @endif
            </div>

            @if ($rental->status == 'pending')
                <div class="flex gap-3">
                    <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST"
                        onsubmit="return confirm('Yakin tolak pesanan ini?');">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-bold transition shadow">
                            Tolak
                        </button>
                    </form>

                    <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST"
                        onsubmit="return confirm('Setujui pesanan ini? Stok akan berkurang (jika fitur stok aktif).');">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold transition shadow">
                            ✓ Setujui Pesanan
                        </button>
                    </form>
                </div>
            @endif

            @if ($rental->status == 'approved')
                <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST"
                    onsubmit="return confirm('Barang sudah dikembalikan dan pesanan selesai?');">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <button class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded font-bold transition shadow">
                        Tandai Selesai (Dikembalikan)
                    </button>
                </form>
            @endif

        </div>

    </div>
@endsection
