@extends('layouts.admin.app')
@section('title', 'Manajemen Barang')

@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.items.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Barang Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3...">Gambar</th>
                    <th class="px-6 py-3 text-left ...">Nama Barang</th>
                    <th class="px-6 py-3 text-left ...">Kategori</th>
                    <th class="px-6 py-3 text-left ...">Harga (per hari)</th>
                    <th class="px-6 py-3 text-left ...">Stok</th>
                    <th class="px-6 py-3 text-right ...">Aksi</th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                @forelse ($items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Foto"
                                    class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $item->name }}</td>
                        <td class="px-6 py-4">
                            {{-- Kita panggil relasi 'category' lalu 'name' --}}
                            {{ $item->category->name }}
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $item->stock }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.items.edit', $item->id) }}"
                                class="text-indigo-600 hover:text-indigo-900 inline-block mr-2">Edit</a>

                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin hapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belim ada data barang.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection
