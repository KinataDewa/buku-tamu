<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_guest_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('event_guests')->onDelete('cascade');
            $table->string('foto')->nullable(); // path foto
            $table->timestamp('waktu_hadir')->useCurrent(); // otomatis isi waktu server
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_guest_attendances');
    }
};
