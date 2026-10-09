<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kinerja', function (Blueprint $table) {
            $table->id();

            $table->string('judul', 150);

            $table->string('kategori', 30);

            $table->date('tanggal');

            $table->text('deskripsi');

            $table->string('lokasi', 255)->nullable();

            $table->foreignId('perangkat_desa_id')
                ->nullable()
                ->constrained('perangkat_desa')
                ->nullOnDelete();

            $table->string('status', 20)->default('draft');

            $table->timestamps();

            $table->index(['status', 'tanggal']);

            $table->index(['kategori', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kinerja');
    }
};