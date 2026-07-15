<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyimpan bukti bahwa user sudah menyetujui Syarat & Ketentuan
     * penyewaan saat mengajukan sewa (checkbox wajib di form sewa).
     */
    public function up(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            if (!Schema::hasColumn('penyewaans', 'setuju_syarat')) {
                $table->boolean('setuju_syarat')->default(false)->after('catatan_admin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            if (Schema::hasColumn('penyewaans', 'setuju_syarat')) {
                $table->dropColumn('setuju_syarat');
            }
        });
    }
};
