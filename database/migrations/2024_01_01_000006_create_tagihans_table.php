<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->enum('jenis', ['UKT', 'SPP', 'DENDA', 'LAINNYA']);
            $table->string('semester', 10);
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['belum_lunas', 'lunas', 'cicilan'])->default('belum_lunas');
            $table->timestamps();
            
            $table->index('mahasiswa_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};