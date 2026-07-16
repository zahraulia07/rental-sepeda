<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Menampilkan halaman "Profil Saya" (edit profil + ganti password)
    public function edit()
    {
        $daftarNotifikasi = DB::table('notifikasis')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $jumlahNotifBelumDibaca = DB::table('notifikasis')
            ->where('user_id', Auth::id())
            ->where('dibaca', false)
            ->count();

        return view('user.profile', [
            'user' => Auth::user(),
            'daftarNotifikasi' => $daftarNotifikasi,
            'jumlahNotifBelumDibaca' => $jumlahNotifBelumDibaca,
        ]);
    }

    // Memperbarui data diri (nama, email, alamat, no HP)
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_ktp' => ['required', 'string', 'size:16', Rule::unique('users', 'no_ktp')->ignore($user->id)],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        } elseif ($request->boolean('hapus_foto') && $user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
            $validated['foto_profil'] = null;
        }
        unset($validated['hapus_foto']);

        $user->update($validated);

        return back()->with('sukses', 'Profil berhasil diperbarui.');
    }

    // Mengubah kata sandi akun
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('sukses', 'Kata sandi berhasil diperbarui.');
    }
}
