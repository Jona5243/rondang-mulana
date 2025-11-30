@extends('layouts.admin.app')
@section('title', 'Notifikasi')

@section('content')

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">

        <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark flex justify-between items-center">
            <h3 class="font-medium text-black dark:text-white">
                Pesan Masuk ({{ $notifications->count() }})
            </h3>

            @if ($notifications->count() > 0)
                <div class="flex gap-2">
                    <form action="{{ route('admin.notifications.markAll') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-xs bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1.5 rounded font-medium transition">
                            ✓ Tandai Semua Dibaca
                        </button>
                    </form>

                    <form action="{{ route('admin.notifications.deleteAll') }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus SEMUA notifikasi?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-xs bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded font-medium transition">
                            🗑️ Hapus Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="flex flex-col p-4 gap-4">
            @forelse($notifications as $notif)
                <div
                    class="group relative flex items-center gap-4 p-4 rounded-lg border-l-4 transition hover:bg-gray-50 dark:hover:bg-meta-4 {{ $notif->read_at ? 'border-gray-300 bg-white' : 'border-blue-500 bg-blue-50' }}">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-blue-500 shadow-sm shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z">
                            </path>
                        </svg>
                    </div>

                    <div class="flex-1 cursor-pointer"
                        onclick="window.location='{{ route('admin.notifications.read', $notif->id) }}'">
                        <h4 class="font-bold text-black dark:text-white text-sm">
                            {{ $notif->data['type'] == 'new_order' ? 'Pesanan Baru' : 'Notifikasi' }}

                            @if (!$notif->read_at)
                                <span class="ml-2 text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full">Baru</span>
                            @endif
                        </h4>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $notif->data['message'] ?? 'Tidak ada pesan' }}
                        </p>

                        <span class="text-xs text-gray-400 mt-2 block">
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST"
                            onsubmit="return confirm('Hapus pesan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition" title="Hapus">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-gray-500">
                    <svg class="mb-4 w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <p>Tidak ada notifikasi saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
