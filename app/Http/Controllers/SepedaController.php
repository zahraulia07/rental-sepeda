<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SepedaController extends Controller
{
    // 1. READ: Menampilkan semua data sepeda (khusus admin), dengan filter status & kategori + search
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

        $daftarSepeda = $query->orderBy('id_sepeda', 'asc')->get();

        // Daftar kategori dinamis untuk dropdown filter
        $daftarKategori = DB::table('sepeda')->distinct()->pluck('kategori');

        return view('admin.sepeda', compact('daftarSepeda', 'daftarKategori'));
    }

    // 2. CREATE: Menyimpan data sepeda baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_per_jam' => ['required', 'integer', 'min:0'],
            'harga_per_hari' => ['required', 'integer', 'min:0'],
            'denda_per_jam' => ['required', 'integer', 'min:0'],
            'denda_per_hari' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Tersedia,Maintenance'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $request->file('gambar')->store('sepeda', 'public');
        }

        DB::table('sepeda')->insert([
            'tipe' => $validated['tipe'],
            'kategori' => $validated['kategori'],
            'gambar' => $pathGambar,
            'stok' => $validated['stok'],
            'harga_per_jam' => $validated['harga_per_jam'],
            'harga_per_hari' => $validated['harga_per_hari'],
            'denda_per_jam' => $validated['denda_per_jam'],
            'denda_per_hari' => $validated['denda_per_hari'],
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/sepeda')->with('sukses', 'Data sepeda berhasil ditambahkan!');
    }

    // 3. UPDATE: Mengubah data sepeda yang sudah ada
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tipe' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_per_jam' => ['required', 'integer', 'min:0'],
            'harga_per_hari' => ['required', 'integer', 'min:0'],
            'denda_per_jam' => ['required', 'integer', 'min:0'],
            'denda_per_hari' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Tersedia,Maintenance'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);

        $dataUpdate = [
            'tipe' => $validated['tipe'],
            'kategori' => $validated['kategori'],
            'stok' => $validated['stok'],
            'harga_per_jam' => $validated['harga_per_jam'],
            'harga_per_hari' => $validated['harga_per_hari'],
            'denda_per_jam' => $validated['denda_per_jam'],
            'denda_per_hari' => $validated['denda_per_hari'],
            'status' => $validated['status'],
            'updated_at' => now(),
        ];

        if ($request->hasFile('gambar')) {
            $sepedaLama = DB::table('sepeda')->where('id_sepeda', $id)->first();
            if ($sepedaLama && $sepedaLama->gambar) {
                Storage::disk('public')->delete($sepedaLama->gambar);
            }
            $dataUpdate['gambar'] = $request->file('gambar')->store('sepeda', 'public');
        }

        DB::table('sepeda')->where('id_sepeda', $id)->update($dataUpdate);

        return redirect('/admin/sepeda')->with('sukses', 'Data sepeda berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus data sepeda dari database
    public function destroy($id)
    {
        $sepeda = DB::table('sepeda')->where('id_sepeda', $id)->first();
        if ($sepeda && $sepeda->gambar) {
            Storage::disk('public')->delete($sepeda->gambar);
        }
        DB::table('sepeda')->where('id_sepeda', $id)->delete();
        return redirect('/admin/sepeda')->with('sukses', 'Data sepeda berhasil dihapus!');
    }
}
