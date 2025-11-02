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
            $table->foreignId('atk_id')->constrained('atks')->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah'); 
            $table->enum('status', ['Menunggu Konfirmasi', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu Konfirmasi');
            $table->timestamp('tanggal_permintaan')->useCurrent(); 
            $table->timestamp('tanggal_persetujuan')->nullable();  
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atk_logs');
    }
};
