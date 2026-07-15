<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'harian'); // harian / mingguan / bulanan

        $now = Carbon::now();
        $mulai = match ($periode) {
            'mingguan' => $now->copy()->startOfWeek(),
            'bulanan' => $now->copy()->startOfMonth(),
            default => $now->copy()->startOfDay(),
        };

        $query = DB::table('penyewaans')
            ->join('sepeda', 'penyewaans.id_sepeda', '=', 'sepeda.id_sepeda')
            ->join('users', 'penyewaans.user_id', '=', 'users.id')
            ->where('penyewaans.status', 'Selesai')
            ->where('penyewaans.updated_at', '>=', $mulai);

        $transaksiSelesai = (clone $query)
            ->select('penyewaans.*', 'sepeda.tipe', 'users.name as nama_penyewa')
            ->orderByDesc('penyewaans.updated_at')
            ->get();

        $totalSewa = $transaksiSelesai->sum('total_biaya');
        $totalDenda = $transaksiSelesai->sum('total_denda');
        $totalPendapatan = $totalSewa + $totalDenda;
        $jumlahTransaksi = $transaksiSelesai->count();

        return view('admin.laporan', compact(
            'periode',
            'transaksiSelesai',
            'totalSewa',
            'totalDenda',
            'totalPendapatan',
            'jumlahTransaksi'
        ));
    }
}
