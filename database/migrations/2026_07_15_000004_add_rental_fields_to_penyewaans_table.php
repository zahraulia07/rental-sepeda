<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            $table->string('jenis_sewa')->default('per_hari')->after('id_sepeda'); // per_jam / per_hari
            $table->unsignedInteger('durasi')->default(1)->after('jenis_sewa'); // jumlah jam/hari
            $table->timestamp('tanggal_ambil')->nullable()->after('tanggal_sewa'); // saat sepeda diambil di lokasi
            $table->timestamp('deadline_kembali')->nullable()->after('tanggal_ambil'); // batas waktu wajib kembali
            $table->unsignedBigInteger('total_biaya')->default(0)->after('deadline_kembali');
            $table->unsignedBigInteger('denda')->default(0)->after('total_biaya');
            $table->string('metode_pembayaran')->nullable()->after('denda'); // transfer / tunai
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran'); // path file bukti transfer
            $table->string('status_pembayaran')->default('Menunggu')->after('bukti_pembayaran'); // Menunggu/Terverifikasi/Ditolak
            $table->text('catatan_admin')->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_sewa',
                'durasi',
                'tanggal_ambil',
                'deadline_kembali',
                'total_biaya',
                'denda',
                'metode_pembayaran',
                'bukti_pembayaran',
                'status_pembayaran',
                'catatan_admin',
            ]);
        });
    }
};
