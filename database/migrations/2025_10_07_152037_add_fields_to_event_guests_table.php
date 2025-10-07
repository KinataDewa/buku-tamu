<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom baru ke tabel event_guests
     */
    public function up(): void
    {
        Schema::table('event_guests', function (Blueprint $table) {
            $table->string('jenis_tamu', 100)->nullable()->after('nama_tamu');
            $table->string('foto')->nullable()->after('jenis_tamu');
            $table->string('no_telp', 20)->nullable()->after('foto');
        });
    }

    /**
     * Hapus kolom jika rollback
     */
    public function down(): void
    {
        Schema::table('event_guests', function (Blueprint $table) {
            $table->dropColumn(['jenis_tamu', 'foto', 'no_telp']);
        });
    }
};
