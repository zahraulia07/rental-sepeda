<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rename kolom 'denda' -> 'total_denda' agar sesuai konvensi:
     * field ini menampung hasil akhir hitungan denda keterlambatan per transaksi.
     */
    public function up(): void
    {
        if (Schema::hasColumn('penyewaans', 'denda') && !Schema::hasColumn('penyewaans', 'total_denda')) {
            Schema::table('penyewaans', function (Blueprint $table) {
                $table->renameColumn('denda', 'total_denda');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('penyewaans', 'total_denda') && !Schema::hasColumn('penyewaans', 'denda')) {
            Schema::table('penyewaans', function (Blueprint $table) {
                $table->renameColumn('total_denda', 'denda');
            });
        }
    }
};
