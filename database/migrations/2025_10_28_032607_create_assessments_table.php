<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id')
                ->constrained('asets')
                ->onDelete('cascade');

            $table->string('condition'); // baru / baik / rusak_ringan / rusak_berat
            $table->integer('score')->default(0); // nilai numerik hasil penilaian
            $table->string('status')->default('Layak'); // status hasil assessment (Layak, Perlu Perbaikan, Tidak Layak)
            $table->text('notes')->nullable(); // catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
