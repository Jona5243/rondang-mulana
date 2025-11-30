<x-app-layout> <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($rentals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b bg-gray-100 font-medium">
                                    <tr>
                                        <th class="px-6 py-4">#ID</th>
                                        <th class="px-6 py-4">Detail Sewa</th>
                                        <th class="px-6 py-4">Barang</th>
                                        <th class="px-6 py-4">Total Biaya</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentals as $rental)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-bold">#{{ $rental->id }}</td>
                                            <td class="px-6 py-4">
                                                {{ date('d M Y', strtotime($rental->start_date)) }} <br>
                                                <span class="text-xs text-gray-500">s/d</span> <br>
                                                {{ date('d M Y', strtotime($rental->end_date)) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <ul class="list-disc list-inside">
                                                    @foreach ($rental->items as $detail)
                                                        <li>{{ $detail->item->name }} (x{{ $detail->quantity }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-blue-600">
                                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($rental->status == 'pending')
                                                    <span
                                                        class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Menunggu</span>
                                                @elseif($rental->status == 'approved')
                                                    <span
                                                        class="bg-green-100 text-green-800 px-2 py-1 rounded">Disetujui</span>
                                                @elseif($rental->status == 'completed')
                                                    <span
                                                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Selesai</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Batal</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-500 mb-4">Anda belum pernah menyewa apapun.</p>
                            <a href="{{ url('/') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mulai Sewa</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
