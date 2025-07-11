<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->date('tanggal_kunjungan')->nullable()->after('telepon');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            //
        });
    }
};
