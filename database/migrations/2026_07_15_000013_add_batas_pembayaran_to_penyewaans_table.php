<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            if (!Schema::hasColumn('penyewaans', 'batas_pembayaran')) {
                $table->timestamp('batas_pembayaran')->nullable()->after('status_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            if (Schema::hasColumn('penyewaans', 'batas_pembayaran')) {
                $table->dropColumn('batas_pembayaran');
            }
        });
    }
};
