<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); 
            $table->string('nama_siswa');
            $table->string('kelas'); 
            $table->date('tanggal_izin');
            $table->string('alasan');
            $table->string('file')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->foreignId('ajukan_izin_id')->nullable()->constrained('ajukan_izins')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes(); // ✅ tambahkan baris ini
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_siswas');
    }
};