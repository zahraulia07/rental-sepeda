<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pengaturan tarif denda per unit sepeda.
     * Admin bisa atur besaran denda per jam & per hari untuk masing-masing sepeda
     * (sebelumnya nilai denda per jam di-hardcode di controller).
     */
    public function up(): void
    {
        Schema::table('sepeda', function (Blueprint $table) {
            if (!Schema::hasColumn('sepeda', 'denda_per_jam')) {
                $table->unsignedBigInteger('denda_per_jam')->default(5000)->after('harga_per_hari');
            }
            if (!Schema::hasColumn('sepeda', 'denda_per_hari')) {
                $table->unsignedBigInteger('denda_per_hari')->default(0)->after('denda_per_jam');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sepeda', function (Blueprint $table) {
            foreach (['denda_per_jam', 'denda_per_hari'] as $col) {
                if (Schema::hasColumn('sepeda', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
