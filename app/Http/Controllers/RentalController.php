<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    // Kirim notifikasi ke SEMUA akun admin
    private function notifikasiAdmin($judul, $pesan, $idPenyewaan = null)
    {
        $adminIds = DB::table('users')->where('role', 'admin')->pluck('id');

        $baris = $adminIds->map(function ($adminId) use ($judul, $pesan, $idPenyewaan) {
            return [
                'user_id' => $adminId,
                'id_penyewaan' => $idPenyewaan,
                'judul' => $judul,
                'pesan' => $pesan,
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        if (!empty($baris)) {
            DB::table('notifikasis')->insert($baris);
        }
    }

    // Dashboard user: katalog sepeda (semua status) + riwayat sewa milik user yang login
    public function index(Request $request)
    {
        $query = DB::table('sepeda');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('cari')) {
            $query->where('tipe', 'like', '%' . $request->cari . '%');
        }

        $sepedaTersedia = $query->orderBy('id_sepeda', 'asc')->get();

        // Daftar kategori dinamis untuk dropdown filter
        $daftarKategori = DB::table('sepeda')->distinct()->pluck('kategori');

        $riwayatSewa = DB::table('penyewaans')
            ->join('sepeda', 'penyewaans.id_sepeda', '=', 'sepeda.id_sepeda')
            ->where('penyewaans.user_id', Auth::id())
            ->orderByDesc('penyewaans.tanggal_sewa')
            ->select('penyewaans.*', 'sepeda.tipe', 'sepeda.harga_per_jam', 'sepeda.harga_per_hari')
            ->get();

        // Notifikasi untuk lonceng di navbar: daftar terbaru + jumlah yang belum dibaca (badge)
        $daftarNotifikasi = DB::table('notifikasis')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $jumlahNotifBelumDibaca = DB::table('notifikasis')
            ->where('user_id', Auth::id())
            ->where('dibaca', false)
            ->count();

        return view('user.dashboard', compact('sepedaTersedia', 'riwayatSewa', 'daftarKategori', 'daftarNotifikasi', 'jumlahNotifBelumDibaca'));
    }

    // Mengajukan sewa sepeda (masuk status Pending, menunggu approval admin)
    public function sewa(Request $request, $id)
    {
        if (Auth::user()->is_blocked) {
            return back()->with('gagal', 'Akun Anda diblokir dan tidak dapat melakukan penyewaan. Hubungi admin untuk info lebih lanjut.');
        }

        $validated = $request->validate([
            'jenis_sewa' => ['required', 'in:per_jam,per_hari'],
            'durasi' => ['required', 'integer', 'min:1'],
            'setuju_syarat' => ['accepted'],
        ], [
            'setuju_syarat.accepted' => 'Anda harus menyetujui Syarat & Ketentuan penyewaan terlebih dahulu.',
        ]);

        $sepeda = DB::table('sepeda')->where('id_sepeda', $id)->first();

        if (!$sepeda || $sepeda->status !== 'Tersedia' || $sepeda->stok < 1) {
            return back()->with('gagal', 'Maaf, sepeda ini sudah tidak tersedia.');
        }

        $hargaSatuan = $validated['jenis_sewa'] === 'per_jam' ? $sepeda->harga_per_jam : $sepeda->harga_per_hari;
        $totalBiaya = $hargaSatuan * $validated['durasi'];

        $idPenyewaan = DB::table('penyewaans')->insertGetId([
            'user_id' => Auth::id(),
            'id_sepeda' => $id,
            'jenis_sewa' => $validated['jenis_sewa'],
            'durasi' => $validated['durasi'],
            'tanggal_sewa' => now(),
            'total_biaya' => $totalBiaya,
            'status' => 'Pending',
            'status_pembayaran' => 'Belum Dibayar',
            'setuju_syarat' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_penyewaan');

        DB::table('sepeda')->where('id_sepeda', $id)->decrement('stok');

        $satuan = $validated['jenis_sewa'] === 'per_jam' ? 'jam' : 'hari';
        $this->notifikasiAdmin(
            'Pengajuan Sewa Baru',
            Auth::user()->name . ' mengajukan sewa "' . $sepeda->tipe . '" selama ' . $validated['durasi'] . ' ' . $satuan . '. Menunggu persetujuan.',
            $idPenyewaan
        );

        return redirect('/dashboard')->with('sukses', 'Pengajuan sewa "' . $sepeda->tipe . '" berhasil dikirim. Menunggu persetujuan admin.');
    }

    // Konfirmasi pembayaran oleh user (VA/QRIS dummy, tanpa upload bukti) -> langsung Sudah Dibayar
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $penyewaan = DB::table('penyewaans')
            ->where('id_penyewaan', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$penyewaan) {
            return back()->with('gagal', 'Data penyewaan tidak ditemukan.');
        }

        $validated = $request->validate([
            'metode_pembayaran' => ['required', 'in:transfer,tunai'],
        ]);

        DB::table('penyewaans')->where('id_penyewaan', $id)->update([
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status_pembayaran' => 'Sudah Dibayar',
            'updated_at' => now(),
        ]);

        $sepeda = DB::table('sepeda')->where('id_sepeda', $penyewaan->id_sepeda)->first();
        $this->notifikasiAdmin(
            'Pembayaran Masuk',
            Auth::user()->name . ' telah membayar sewa "' . ($sepeda->tipe ?? '-') . '" sebesar Rp ' . number_format($penyewaan->total_biaya, 0, ',', '.') . '.',
            $id
        );

        return back()->with('sukses', 'Pembayaran berhasil dikonfirmasi.');
    }

    // Nota digital / kuitansi rincian biaya untuk transaksi yang sudah selesai
    public function nota($id)
    {
        $nota = DB::table('penyewaans')
            ->join('sepeda', 'penyewaans.id_sepeda', '=', 'sepeda.id_sepeda')
            ->join('users', 'penyewaans.user_id', '=', 'users.id')
            ->where('penyewaans.id_penyewaan', $id)
            ->where('penyewaans.user_id', Auth::id())
            ->select('penyewaans.*', 'sepeda.tipe', 'sepeda.kategori', 'users.name as nama_penyewa')
            ->first();

        if (!$nota || $nota->status !== 'Selesai') {
            return back()->with('gagal', 'Nota hanya tersedia untuk transaksi yang sudah selesai.');
        }

        return view('user.nota', compact('nota'));
    }
}
