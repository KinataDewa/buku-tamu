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
            $table->string('nomor_kartu')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropColumn('nomor_kartu');
        });
    }
};
