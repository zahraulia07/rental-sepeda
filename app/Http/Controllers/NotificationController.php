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
}
