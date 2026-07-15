<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sepeda')) {
            // Belum ada tabelnya sama sekali -> buat baru
            Schema::create('sepeda', function (Blueprint $table) {
                $table->id('id_sepeda');
                $table->string('tipe');
                $table->string('kategori')->default('MTB'); // MTB, Sepeda Listrik, Roadbike, dll
                $table->unsignedInteger('stok')->default(1); // jumlah unit tersedia
                $table->unsignedBigInteger('harga_per_jam');
                $table->unsignedBigInteger('harga_per_hari');
                $table->string('status')->default('Tersedia'); // Tersedia / Maintenance
                $table->timestamps();
            });
            return;
        }

        // Tabel sudah ada (dari database lama) -> tambahin kolom yang belum ada saja,
        // data yang sudah ada (pelanggan, pembayaran, dll tidak kesentuh) aman.
        Schema::table('sepeda', function (Blueprint $table) {
            if (!Schema::hasColumn('sepeda', 'kategori')) {
                $table->string('kategori')->default('MTB')->after('tipe');
            }
            if (!Schema::hasColumn('sepeda', 'stok')) {
                $table->unsignedInteger('stok')->default(1)->after('kategori');
            }
            if (!Schema::hasColumn('sepeda', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('sepeda')) {
            Schema::table('sepeda', function (Blueprint $table) {
                foreach (['kategori', 'stok', 'created_at', 'updated_at'] as $col) {
                    if (Schema::hasColumn('sepeda', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
