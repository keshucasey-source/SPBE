<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_pajaks', function (Blueprint $table) {
            $table->id();

            $table->string('judul', 150);

            $table->string('kategori', 50);

            $table->text('isi');

            $table->date('tanggal_publikasi');

            $table->string('status', 20)
                ->default('draft');

            $table->timestamps();

            $table->index([
                'kategori',
                'status',
                'tanggal_publikasi',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_pajaks');
    }
};