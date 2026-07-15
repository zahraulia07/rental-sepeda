<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('tempat_lahir')->nullable()->after('email');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->string('no_ktp', 16)->unique()->nullable()->after('alamat');
            $table->string('no_hp')->nullable()->after('no_ktp');
            $table->string('role')->default('user')->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat',
                'no_ktp',
                'no_hp',
                'role',
            ]);
        });
    }
};
