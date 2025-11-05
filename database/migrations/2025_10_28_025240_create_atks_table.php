<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->integer('stok')->default(0);
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('satuan');
            $table->integer('stok_minimum')->default(5);
            $table->integer('harga_satuan')->nullable();
            $table->integer('total_harga')->default(0);
            $table->date('tanggal_masuk')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreignId('procurement_id')->constrained('atk_procurements')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atks');
    }
};
