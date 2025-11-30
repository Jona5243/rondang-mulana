@extends('layouts.admin.app')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold opacity-75">Total Pesanan Masuk</h3>
            <p class="text-3xl font-bold">{{ $total_pesanan }}</p>
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold opacity-75">Pendapatan (Selesai)</h3>
            <p class="text-3xl font-bold">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold opacity-75">Perlu Konfirmasi</h3>
            <p class="text-3xl font-bold">{{ $pesanan_pending }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-700">Pesanan Terbaru</h3>
            <a href="{{ route('admin.rentals.index') }}" class="text-blue-600 hover:underline text-sm">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rentals as $rental)
                        <tr>
                            <td class="px-6 py-4">
                                <span class="font-bold">{{ $rental->user->name }}</span>
                                <div class="text-xs text-gray-500">#{{ $rental->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($rental->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Pending</span>
                                @elseif($rental->status == 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Approved</span>
                                @elseif($rental->status == 'completed')
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Selesai</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Batal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-700">
                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $rental->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
