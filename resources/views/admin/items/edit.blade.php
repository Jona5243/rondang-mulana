@extends('layouts.admin.app')
@section('title', 'Edit Barang')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                <input type="text" name="name" value="{{ $item->name }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ $item->description }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga Sewa</label>
                    <input type="number" name="price_per_day" value="{{ $item->price_per_day }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ $item->stock }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Foto (Opsional)</label>
                <input type="file" name="image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                @if ($item->image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 mb-1">Foto Saat Ini:</p>
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Foto Lama"
                            class="w-32 h-32 object-cover rounded border">
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.items.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
            </div>
        </form>
    </div>
@endsection
