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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inventaris')->unique();
            $table->string('nama');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('merek')->nullable();
            $table->string('tipe')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('tanggal_perolehan');
            $table->integer('umur_ekonomis')->default(5);
            $table->decimal('harga', 15, 2);
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            $table->enum('kondisi', ['baru', 'baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->enum('status', ['aktif', 'dipinjam', 'diperbaiki', 'dihapuskan'])->default('aktif');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
