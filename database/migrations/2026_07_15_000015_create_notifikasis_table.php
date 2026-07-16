<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyimpan notifikasi untuk user, misalnya saat admin menyetujui/menolak
     * pengajuan sewa. Dipakai untuk badge angka lonceng notifikasi di navbar.
     */
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('id_penyewaan')->nullable();
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('dibaca')->default(false);
            $table->timestamps();

            $table->index('id_penyewaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
