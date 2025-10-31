<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atk_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atk_id')->constrained('atks')->onDelete('cascade'); // relasi ke tabel ATK
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // siapa yang mengajukan permintaan
            
            $table->integer('jumlah'); // jumlah yang diminta
            
            // status permintaan: pending, disetujui, ditolak, diambil, dll.
            $table->enum('status', ['Menunggu Konfirmasi', 'Disetujui', 'Ditolak', 'Selesai'])
                  ->default('Menunggu Konfirmasi');
            
            $table->timestamp('tanggal_permintaan')->useCurrent(); // tanggal permintaan
            $table->timestamp('tanggal_persetujuan')->nullable();  // jika disetujui/selesai
            
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atk_logs');
    }
};
