<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data user, urutkan dari yang terbaru
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    // Nanti bisa tambah fitur Hapus User jika mau
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah Admin menghapus dirinya sendiri
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
