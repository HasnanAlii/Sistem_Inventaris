<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_atks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atk_id')->constrained('atks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('jumlah')->default(1);
            $table->string('status')->default('menunggu'); 
            $table->date('tanggal_permintaan')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_atks');
    }
};
