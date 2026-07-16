<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    // Tandai semua notifikasi milik user yang login sebagai sudah dibaca
    // (dipanggil otomatis via fetch() saat dropdown lonceng dibuka)
    public function tandaiDibaca(Request $request)
    {
        DB::table('notifikasis')
            ->where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true, 'updated_at' => now()]);

        return response()->json(['ok' => true]);
    }

    // Diklik dari satu item notifikasi: tandai notifikasi itu (+ notifikasi lain
    // untuk transaksi yang sama) sebagai sudah dibaca, lalu arahkan ke halaman terkait
    public function bukaTransaksi($id)
    {
        $notif = DB::table('notifikasis')
            ->where('id_notifikasi', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notif) {
            DB::table('notifikasis')
                ->where('user_id', Auth::id())
                ->where('id_penyewaan', $notif->id_penyewaan)
                ->update(['dibaca' => true, 'updated_at' => now()]);
        }

        $tujuan = Auth::user()->role === 'admin' ? '/admin/transaksi' : '/dashboard';

        return redirect($tujuan);
    }
}
