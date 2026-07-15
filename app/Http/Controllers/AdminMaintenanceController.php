<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMaintenanceController extends Controller
{
    // Daftar semua log maintenance, join dengan data sepeda
    public function index(Request $request)
    {
        $query = DB::table('maintenance_logs')
            ->join('sepeda', 'maintenance_logs.id_sepeda', '=', 'sepeda.id_sepeda')
            ->select('maintenance_logs.*', 'sepeda.tipe', 'sepeda.kategori');

        if ($request->filled('id_sepeda')) {
            $query->where('maintenance_logs.id_sepeda', $request->id_sepeda);
        }

        $logMaintenance = $query->orderByDesc('maintenance_logs.tanggal_servis')->get();
        $daftarSepeda = DB::table('sepeda')->orderBy('tipe')->get();

        return view('admin.maintenance', compact('logMaintenance', 'daftarSepeda'));
    }

    // Catat kerusakan baru untuk sejumlah unit tertentu & kurangi stok tersedia sebanyak itu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sepeda' => ['required', 'exists:sepeda,id_sepeda'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'kerusakan' => ['required', 'string', 'max:255'],
            'tanggal_servis' => ['required', 'date'],
            'biaya' => ['nullable', 'integer', 'min:0'],
            'catatan' => ['nullable', 'string'],
        ]);

        $sepeda = DB::table('sepeda')->where('id_sepeda', $validated['id_sepeda'])->first();

        if (!$sepeda) {
            return back()->with('gagal', 'Data sepeda tidak ditemukan.');
        }

        if ($validated['jumlah'] > $sepeda->stok) {
            return back()->with('gagal', 'Jumlah unit maintenance (' . $validated['jumlah'] . ') melebihi stok tersedia saat ini (' . $sepeda->stok . ').');
        }

        DB::table('maintenance_logs')->insert([
            'id_sepeda' => $validated['id_sepeda'],
            'jumlah' => $validated['jumlah'],
            'kerusakan' => $validated['kerusakan'],
            'tanggal_servis' => $validated['tanggal_servis'],
            'biaya' => $validated['biaya'] ?? 0,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Proses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hanya kurangi stok sejumlah unit yang di-maintenance, sisanya tetap bisa disewa
        DB::table('sepeda')->where('id_sepeda', $validated['id_sepeda'])->decrement('stok', $validated['jumlah']);

        return back()->with('sukses', $validated['jumlah'] . ' unit "' . $sepeda->tipe . '" dicatat maintenance, stok tersedia otomatis berkurang.');
    }

    // Tandai servis selesai: unit yang tadi di-maintenance dikembalikan lagi ke stok tersedia
    public function selesai($id)
    {
        $log = DB::table('maintenance_logs')->where('id', $id)->first();
        if (!$log || $log->status === 'Selesai') {
            return back()->with('gagal', 'Data maintenance tidak ditemukan atau sudah selesai.');
        }

        DB::table('maintenance_logs')->where('id', $id)->update([
            'status' => 'Selesai',
            'updated_at' => now(),
        ]);

        DB::table('sepeda')->where('id_sepeda', $log->id_sepeda)->increment('stok', $log->jumlah);

        return back()->with('sukses', $log->jumlah . ' unit selesai servis, stok tersedia sudah ditambahkan kembali.');
    }
}
