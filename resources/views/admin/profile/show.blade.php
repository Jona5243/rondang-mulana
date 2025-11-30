@extends('layouts.admin.app')
@section('title', 'Profil Saya')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-bold text-gray-800">Informasi Akun</h3>
            
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                ADMINISTRATOR
            </span>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center text-3xl font-bold text-white uppercase border-4 border-gray-100">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h4 class="text-xl font-bold text-black">{{ $user->name }}</h4>
                <p class="text-sm text-gray-500">Bergabung sejak {{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="space-y-3 text-sm border-t pt-4">
            <p><span class="text-gray-500 block">Email:</span> {{ $user->email }}</p>
            <p><span class="text-gray-500 block">ID Pengguna:</span> #{{ $user->id }}</p>
            <p><span class="text-gray-500 block">Status Akun:</span> <span class="text-green-600 font-bold">Aktif</span></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 flex flex-col justify-center">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Saya</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded border border-gray-100 text-center">
                <span class="text-3xl font-bold text-blue-600 block">
                    {{ \App\Models\Rental::count() }}
                </span>
                <span class="text-xs text-gray-500 uppercase font-bold">Total Pesanan Sistem</span>
            </div>

            <div class="p-4 bg-gray-50 rounded border border-gray-100 text-center">
                <span class="text-3xl font-bold text-green-600 block">
                    {{ \App\Models\Item::count() }}
                </span>
                <span class="text-xs text-gray-500 uppercase font-bold">Barang Dikelola</span>
            </div>
        </div>

        <div class="mt-6 text-xs text-gray-400 text-center">
            Anda memiliki akses penuh untuk mengelola seluruh data sistem Rondang Mulana.
        </div>
    </div>

    <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-200 flex justify-between items-center">
        
        <div class="text-sm text-gray-500">
            Terakhir diperbarui: {{ $user->updated_at->diffForHumans() }}
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('profile.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded font-bold transition shadow flex items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit Profil & Password
            </a>
        </div>

    </div>

</div>
@endsection