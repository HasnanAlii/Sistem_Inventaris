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
            $table->foreignId('aset_id')->constrained('asets')->onDelete('cascade');
            $table->string('condition');     
            $table->integer('usia_bulan')->default(0); 
            $table->integer('perbaikan')->default(0);  
            $table->integer('score')->default(0);      
            $table->string('status')->default('Layak'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
