<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKinerjaFoto extends Model
{
    use HasFactory;

    protected $table = 'laporan_kinerja_fotos';

    protected $fillable = [
        'laporan_kinerja_id',
        'file_path',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    public function laporanKinerja(): BelongsTo
    {
        return $this->belongsTo(
            LaporanKinerja::class,
            'laporan_kinerja_id'
        );
    }
}