<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sepeda');
            $table->foreign('id_sepeda')->references('id_sepeda')->on('sepeda')->cascadeOnDelete();
            $table->string('kerusakan'); // bagian yang rusak / dikerjakan
            $table->date('tanggal_servis');
            $table->unsignedBigInteger('biaya')->default(0);
            $table->text('catatan')->nullable();
            $table->string('status')->default('Proses'); // Proses / Selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
