@extends('layouts.admin.app')
@section('title', 'Manajemen Pesanan Masuk')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID / Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail Sewa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($rentals as $rental)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="font-bold text-blue-600">#{{ $rental->id }}</span><br>
                            {{ $rental->user->name }}<br>
                            <span class="text-xs text-gray-500">{{ $rental->user->email }}</span>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <span class="font-bold">Mulai:</span> {{ $rental->start_date }}<br>
                            <span class="font-bold">Selesai:</span> {{ $rental->end_date }}<br>
                            <hr class="my-1">
                            <span class="text-xs text-gray-500">{{ Str::limit($rental->address, 50) }}</span>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($rental->items as $detail)
                                    <li>{{ $detail->item->name }} (x{{ $detail->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>

                        <td class="px-6 py-4 font-bold">
                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($rental->status == 'pending')
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Pending</span>
                            @elseif($rental->status == 'approved')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">Approved</span>
                            @elseif($rental->status == 'completed')
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">Batal</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.rentals.show', $rental->id) }}"
                                    class="inline-flex items-center justify-center rounded-md border border-primary py-2 px-4 text-center font-medium text-primary hover:bg-opacity-90 lg:px-4 xl:px-4 text-sm hover:bg-blue-50 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">Belum ada pesanan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
