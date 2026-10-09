<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kinerja_fotos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_kinerja_id')
                ->constrained('laporan_kinerja')
                ->cascadeOnDelete();

            $table->string('file_path');

            $table->unsignedInteger('urutan')->default(0);

            $table->timestamps();

            $table->index([
                'laporan_kinerja_id',
                'urutan',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kinerja_fotos');
    }
}; 