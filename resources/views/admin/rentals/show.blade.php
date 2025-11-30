@extends('layouts.admin.app')
@section('title', 'Detail Pesanan #' . $rental->id)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Informasi Penyewa</h3>
            <p><strong>Nama:</strong> {{ $rental->user->name }}</p>
            <p><strong>Email:</strong> {{ $rental->user->email }}</p>
            <p><strong>Tanggal Sewa:</strong> {{ $rental->start_date }} s/d {{ $rental->end_date }}</p>
            <p><strong>Alamat:</strong> {{ $rental->address }}</p>

            <div class="mt-6 p-4 bg-gray-100 rounded">
                <p class="text-xl font-bold text-blue-600">Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                </p>
                <p class="mt-2">Status Saat Ini:
                    <span
                        class="px-2 py-1 rounded text-xs font-bold 
                    {{ $rental->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                    {{ $rental->status == 'approved' ? 'bg-green-200 text-green-800' : '' }}
                    {{ $rental->status == 'cancelled' ? 'bg-red-200 text-red-800' : '' }}">
                        {{ strtoupper($rental->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Barang Disewa</h3>
            <ul class="divide-y divide-gray-200">
                @foreach ($rental->items as $detail)
                    <li class="py-3 flex justify-between">
                        <div class="flex items-center">
                            @if ($detail->item->image)
                                <img src="{{ asset('storage/' . $detail->item->image) }}"
                                    class="w-10 h-10 rounded object-cover mr-3">
                            @endif
                            <span>{{ $detail->item->name }}</span>
                        </div>
                        <span class="font-bold">x {{ $detail->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <a href="{{ route('admin.rentals.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali ke Daftar</a>

            @if ($rental->status == 'pending')
                <div class="flex gap-4">
                    <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-bold">Tolak
                            Pesanan</button>
                    </form>

                    <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded font-bold">Setujui
                            Pesanan</button>
                    </form>
                </div>
            @endif
        </div>

    </div>
@endsection
