{{-- Ini memberitahu Blade untuk menggunakan layout admin kita --}}
@extends('layouts.admin.app')

{{-- Ini mengisi bagian 'title' di layout --}}
@section('title', 'Manajemen Kategori')

{{-- Ini mengisi bagian 'content' di layout --}}
@section('content')

    <div class="mb-4">
        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Kategori Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                {{-- Ini adalah Blade Loop. Jika $categories kosong, tampilkan pesan. --}}
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Ini akan tampil jika tidak ada data di database --}}
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

@endsection
