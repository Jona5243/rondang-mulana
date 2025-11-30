@extends('layouts.admin.app')
@section('title', 'Profil Saya')

@section('content')
    <div class="mx-auto max-w-270">

        <div class="grid grid-cols-1 gap-8">

            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Informasi Profil
                    </h3>
                </div>
                <div class="p-7">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('patch')

                        <div class="mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="name">Nama
                                Lengkap</label>
                            <input
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                                type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                autofocus autocomplete="name">
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="email">Alamat
                                Email</label>
                            <input
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                                type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required autocomplete="username">
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex justify-end gap-4.5">
                            <button
                                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90 bg-blue-600 text-white transition"
                                type="submit">
                                Simpan Perubahan
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-green-600 self-center">
                                    Tersimpan.
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Ganti Password
                    </h3>
                </div>
                <div class="p-7">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white"
                                for="current_password">Password Saat Ini</label>
                            <input
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                                type="password" name="current_password" id="current_password"
                                autocomplete="current-password">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div class="mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="password">Password
                                Baru</label>
                            <input
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                                type="password" name="password" id="password" autocomplete="new-password">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white"
                                for="password_confirmation">Konfirmasi Password Baru</label>
                            <input
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                                type="password" name="password_confirmation" id="password_confirmation"
                                autocomplete="new-password">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-4.5">
                            <button
                                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90 bg-blue-600 text-white transition"
                                type="submit">
                                Update Password
                            </button>

                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-green-600 self-center">
                                    Password Berhasil Diganti.
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
