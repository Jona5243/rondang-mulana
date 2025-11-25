@extends('layouts.admin.app')

@section('title', 'Edit Kategori') @section('content')

<div class="bg-white p-6 rounded-lg shadow-md">
    
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $category->name }}" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

@endsection