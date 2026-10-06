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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 150);

            $table->string('kategori', 30);

            $table->text('deskripsi')->nullable();

            $table->string('alamat', 255);

            $table->string('foto')->nullable();

            $table->unsignedInteger('urutan')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index([
                'kategori',
                'is_active',
                'urutan',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};