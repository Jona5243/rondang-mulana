<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Profil Admin (View Only).
     */
    public function show(Request $request): View
    {
        // Pastikan hanya admin yang bisa lihat tampilan ini
        if ($request->user()->role === \App\Enums\UserRole::ADMIN) {
            return view('admin.profile.show', [
                'user' => $request->user(),
            ]);
        }

        // Jika user biasa, langsung ke edit saja (atau buat view user nanti)
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        // LOGIKA BARU: Cek jika Admin
        if ($request->user()->role === \App\Enums\UserRole::ADMIN) {
            return view('admin.profile.edit', [
                'user' => $request->user(),
            ]);
        }

        // Tampilan User Biasa (Bawaan)
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
