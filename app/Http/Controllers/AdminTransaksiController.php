<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminTransaksiController extends Controller
{
    // Denda per jam keterlambatan (dipakai hanya sebagai fallback jika sepeda belum punya tarif sendiri)
    const DENDA_PER_JAM = 5000;

    private function baseQuery()
    {
        return DB::table('penyewaans')
            ->join('sepeda', 'penyewaans.id_sepeda', '=', 'sepeda.id_sepeda')
            ->join('users', 'penyewaans.user_id', '=', 'users.id')
            ->select(
                'penyewaans.*',
                'sepeda.tipe',
                'sepeda.kategori',
                'sepeda.harga_per_jam',
                'sepeda.harga_per_hari',
                'sepeda.denda_per_jam',
                'sepeda.denda_per_hari',
                'users.id as user_id',
                'users.name as nama_penyewa',
                'users.username',
                'users.email',
                'users.tempat_lahir',
                'users.tanggal_lahir',
                'users.jenis_kelamin',
                'users.no_ktp',
                'users.no_hp',
                'users.alamat',
                'users.foto_profil',
                'users.is_blocked',
                'users.alasan_blokir',
                DB::raw('(select count(*) from penyewaans p2 where p2.user_id = users.id) as total_transaksi')
            );
    }

    // Daftar transaksi aktif (Pending, Disetujui, Sedang Disewa) + search & filter
    public function index(Request $request)
    {
        $query = $this->baseQuery()->whereIn('penyewaans.status', ['Pending', 'Disetujui', 'Sedang Disewa']);

        if ($request->filled('status')) {
            $query->where('penyewaans.status', $request->status);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('users.name', 'like', "%{$cari}%")
                  ->orWhere('penyewaans.id_penyewaan', 'like', "%{$cari}%");
            });
        }

        $daftarTransaksi = $query->orderByDesc('penyewaans.tanggal_sewa')->get();

        return view('admin.transaksi', compact('daftarTransaksi'));
    }

    // Riwayat transaksi yang sudah Selesai / Ditolak
    public function riwayat(Request $request)
    {
        $query = $this->baseQuery()->whereIn('penyewaans.status', ['Selesai', 'Ditolak']);

        if ($request->filled('status')) {
            $query->where('penyewaans.status', $request->status);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('users.name', 'like', "%{$cari}%")
                  ->orWhere('penyewaans.id_penyewaan', 'like', "%{$cari}%");
            });
        }

        $riwayat = $query->orderByDesc('penyewaans.updated_at')->paginate(15)->withQueryString();

        return view('admin.riwayat', compact('riwayat'));
    }

    // Approval: Pending -> Disetujui
    public function setujui($id)
    {
        $transaksi = DB::table('penyewaans')->where('id_penyewaan', $id)->first();
        if (!$transaksi || $transaksi->status !== 'Pending') {
            return back()->with('gagal', 'Transaksi tidak valid untuk disetujui.');
        }

        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status' => 'Disetujui',
            'batas_pembayaran' => Carbon::now()->addHours(2),
            'updated_at' => now(),
        ]);

        return back()->with('sukses', 'Pesanan #' . $id . ' berhasil disetujui.');
    }

    // Approval: Pending -> Ditolak (stok dikembalikan)
    public function tolak(Request $request, $id)
    {
        $transaksi = DB::table('penyewaans')->where('id_penyewaan', $id)->first();
        if (!$transaksi || $transaksi->status !== 'Pending') {
            return back()->with('gagal', 'Transaksi tidak valid untuk ditolak.');
        }

        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin,
            'updated_at' => now(),
        ]);

        DB::table('sepeda')->where('id_sepeda', $transaksi->id_sepeda)->increment('stok');

        return back()->with('sukses', 'Pesanan #' . $id . ' ditolak, stok sepeda dikembalikan.');
    }

    // Konfirmasi Ambil Sepeda: Disetujui -> Sedang Disewa, deadline mulai dihitung
    public function ambil($id)
    {
        $transaksi = DB::table('penyewaans')->where('id_penyewaan', $id)->first();
        if (!$transaksi || $transaksi->status !== 'Disetujui') {
            return back()->with('gagal', 'Transaksi belum disetujui / tidak valid.');
        }

        $sekarang = Carbon::now();
        $deadline = $transaksi->jenis_sewa === 'per_jam'
            ? $sekarang->copy()->addHours($transaksi->durasi)
            : $sekarang->copy()->addDays($transaksi->durasi);

        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status' => 'Sedang Disewa',
            'tanggal_ambil' => $sekarang,
            'deadline_kembali' => $deadline,
            'updated_at' => now(),
        ]);

        return back()->with('sukses', 'Sepeda untuk transaksi #' . $id . ' sudah diambil penyewa. Batas kembali: ' . $deadline->format('d M Y H:i'));
    }

    // Konfirmasi Pengembalian: Sedang Disewa -> Selesai, hitung denda otomatis, stok & status sepeda dikembalikan
    public function kembalikan($id)
    {
        $transaksi = DB::table('penyewaans')->where('id_penyewaan', $id)->first();
        if (!$transaksi || $transaksi->status !== 'Sedang Disewa') {
            return back()->with('gagal', 'Transaksi tidak valid untuk dikembalikan.');
        }

        $sekarang = Carbon::now();
        $denda = 0;
        $keterlambatan = null;

        if ($transaksi->deadline_kembali && $sekarang->greaterThan(Carbon::parse($transaksi->deadline_kembali))) {
            $sepeda = DB::table('sepeda')->where('id_sepeda', $transaksi->id_sepeda)->first();
            $dendaPerJam = $sepeda->denda_per_jam ?? self::DENDA_PER_JAM;
            $dendaPerHari = $sepeda->denda_per_hari ?? 0;
            $deadline = Carbon::parse($transaksi->deadline_kembali);

            if ($transaksi->jenis_sewa === 'per_hari' && $dendaPerHari > 0) {
                // Sewa per hari dengan tarif denda harian sendiri: hitung per hari keterlambatan
                $hariTelat = (int) ceil($deadline->diffInHours($sekarang) / 24);
                $denda = $hariTelat * $dendaPerHari;
                $keterlambatan = $hariTelat . ' hari (tarif Rp ' . number_format($dendaPerHari, 0, ',', '.') . '/hari)';
            } else {
                // Default: hitung per jam keterlambatan
                $jamTelat = (int) ceil($deadline->diffInMinutes($sekarang) / 60);
                $denda = $jamTelat * $dendaPerJam;
                $keterlambatan = $jamTelat . ' jam (tarif Rp ' . number_format($dendaPerJam, 0, ',', '.') . '/jam)';
            }
        }

        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'status' => 'Selesai',
            'tanggal_selesai' => $sekarang,
            'total_denda' => $denda,
            'updated_at' => now(),
        ]);

        DB::table('sepeda')->where('id_sepeda', $transaksi->id_sepeda)->increment('stok');

        // Ringkasan tagihan otomatis: durasi keterlambatan & nominal denda yang harus ditagih ke user
        $pesan = 'Sepeda untuk transaksi #' . $id . ' berhasil dikembalikan.';
        $pesan .= $denda > 0
            ? ' Telat ' . $keterlambatan . '. Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.') . '.'
            : ' Tidak ada denda (kembali tepat waktu).';

        return back()->with('sukses', $pesan);
    }
}
