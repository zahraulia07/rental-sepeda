<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Perbaiki kategori data lama (dulu semua ke-default 'MTB' saat kolomnya baru ditambahkan)
        $perbaikan = [
            'Polygon Xtrada 6 (MTB)' => 'MTB',
            'United E-Trifold (Sepeda Listrik Lipat)' => 'Sepeda Listrik',
            'Exotic Explore 9.0 (Folding Bike)' => 'Lainnya',
            'Element FRC 52 (Roadbike)' => 'Roadbike',
            'Wimcycle Pocket Rocket' => 'Lainnya',
            'Sepeda Lipat Exotic' => 'Lainnya',
        ];

        foreach ($perbaikan as $tipe => $kategori) {
            DB::table('sepeda')->where('tipe', $tipe)->update(['kategori' => $kategori]);
        }

        // Tambah armada baru supaya tiap kategori punya minimal 2 sepeda
        $sepedaBaru = [
            [
                'tipe' => 'Thrill Cleave 3.1 (MTB)',
                'kategori' => 'MTB',
                'stok' => 3,
                'harga_per_jam' => 22000,
                'harga_per_hari' => 100000,
                'denda_per_jam' => 5000,
                'denda_per_hari' => 0,
                'status' => 'Tersedia',
            ],
            [
                'tipe' => 'Selis E-Klik (Sepeda Listrik)',
                'kategori' => 'Sepeda Listrik',
                'stok' => 2,
                'harga_per_jam' => 40000,
                'harga_per_hari' => 170000,
                'denda_per_jam' => 8000,
                'denda_per_hari' => 0,
                'status' => 'Tersedia',
            ],
            [
                'tipe' => 'Pacific Velox 700C (Roadbike)',
                'kategori' => 'Roadbike',
                'stok' => 2,
                'harga_per_jam' => 27000,
                'harga_per_hari' => 130000,
                'denda_per_jam' => 6000,
                'denda_per_hari' => 0,
                'status' => 'Tersedia',
            ],
        ];

        foreach ($sepedaBaru as $data) {
            $ada = DB::table('sepeda')->where('tipe', $data['tipe'])->exists();
            if (!$ada) {
                DB::table('sepeda')->insert(array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('sepeda')->whereIn('tipe', [
            'Thrill Cleave 3.1 (MTB)',
            'Selis E-Klik (Sepeda Listrik)',
            'Pacific Velox 700C (Roadbike)',
        ])->delete();
    }
};
