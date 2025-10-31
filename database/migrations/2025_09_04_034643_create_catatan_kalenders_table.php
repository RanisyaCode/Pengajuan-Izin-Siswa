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
        Schema::create('catatan_kalenders', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->text('catatan');

            // Tambahan kolom kategori acara (penting untuk warna kalender)
            $table->string('kategori')->default('Acara Pribadi');
            // Contoh nilai: Acara Pribadi, Acara Sekolah, Penting, Acara Lainnya

            // Role pembuat catatan (admin / siswa)
            $table->string('role')->default('siswa');

            // Relasi ke user yang membuat catatan
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_kalenders');
    }
};
