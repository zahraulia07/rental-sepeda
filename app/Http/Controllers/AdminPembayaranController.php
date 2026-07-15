<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPembayaranController extends Controller
{
    // Daftar pembayaran yang butuh verifikasi admin (bukti sudah diupload user)
    public function index()
    {
        $daftarPembayaran = DB::table('penyewaans')
            ->join('sepeda', 'penyewaans.id_sepeda', '=', 'sepeda.id_sepeda')
            ->join('users', 'penyewaans.user_id', '=', 'users.id')
            ->whereNotNull('penyewaans.bukti_pembayaran')
            ->select(
                'penyewaans.*',
                'sepeda.tipe',
                'users.name as nama_penyewa'
            )
            ->orderByRaw("CASE WHEN penyewaans.status_pembayaran = 'Menunggu' THEN 0 ELSE 1 END")
            ->orderByDesc('penyewaans.updated_at')
            ->get();

        return view('admin.pembayaran', compact('daftarPembayaran'));
    }

    // Konfirmasi bukti transfer valid
    public function verifikasi($id)
    {
        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status_pembayaran' => 'Terverifikasi',
            'updated_at' => now(),
        ]);

        return back()->with('sukses', 'Pembayaran transaksi #' . $id . ' terverifikasi.');
    }

    // Tolak bukti transfer (tidak valid / tidak sesuai)
    public function tolak($id)
    {
        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status_pembayaran' => 'Ditolak',
            'updated_at' => now(),
        ]);

        return back()->with('sukses', 'Pembayaran transaksi #' . $id . ' ditolak. Minta user upload ulang.');
    }
}
