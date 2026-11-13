<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel users (petugas yang mencatat anggota)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nomor_anggota', 20)->unique();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('telepon', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
