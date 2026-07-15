<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPelangganController extends Controller
{
    // Daftar semua pelanggan (role: user) beserta jumlah transaksi mereka
    public function index(Request $request)
    {
        $query = DB::table('users')->where('role', 'user');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('username', 'like', "%{$cari}%")
                  ->orWhere('no_ktp', 'like', "%{$cari}%");
            });
        }

        $daftarPelanggan = $query->orderBy('name')->get()->map(function ($user) {
            $user->total_transaksi = DB::table('penyewaans')->where('user_id', $user->id)->count();
            return $user;
        });

        return view('admin.pelanggan', compact('daftarPelanggan'));
    }

    // Blokir akun pelanggan yang bermasalah
    public function blokir(Request $request, $id)
    {
        $request->validate([
            'alasan_blokir' => ['required', 'string', 'max:255'],
        ]);

        DB::table('users')->where('id', $id)->where('role', 'user')->update([
            'is_blocked' => true,
            'alasan_blokir' => $request->alasan_blokir,
        ]);

        return back()->with('sukses', 'Akun pelanggan berhasil diblokir.');
    }

    // Buka blokir akun pelanggan
    public function bukaBlokir($id)
    {
        DB::table('users')->where('id', $id)->where('role', 'user')->update([
            'is_blocked' => false,
            'alasan_blokir' => null,
        ]);

        return back()->with('sukses', 'Blokir akun pelanggan telah dibuka.');
    }
}
