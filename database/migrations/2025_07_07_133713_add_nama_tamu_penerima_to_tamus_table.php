<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->string('nama_tamu')->after('jenis_tamu');
            $table->string('nama_penerima')->after('nama_tamu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropColumn(['nama_tamu', 'nama_penerima']);
        });
    }
};
