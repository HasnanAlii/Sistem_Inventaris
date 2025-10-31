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
            // $table->string('satuan'); // misal: pcs, box, rim
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->integer('harga_satuan')->nullable();
            // $table->string('kondisi')->default('baik'); // baik, rusak
            $table->date('tanggal_masuk')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atks');
    }
};
