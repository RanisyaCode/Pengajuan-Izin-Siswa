<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajukan_izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('izin_siswa_id')->nullable();
            $table->string('nama_siswa')->nullable();
            $table->string('kelas')->nullable(); 
            $table->date('tanggal_izin');
            $table->string('alasan');
            $table->string('file')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ✅ tambahkan ini
        });
    }

    public function down(): void
    {
        Schema::table('ajukan_izins', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });
        Schema::dropIfExists('ajukan_izins');
    }
};
