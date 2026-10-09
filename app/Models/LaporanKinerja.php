<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanKinerja extends Model
{
    use HasFactory;

    protected $table = 'laporan_kinerja';

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'deskripsi',
        'lokasi',
        'perangkat_desa_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function perangkatDesa(): BelongsTo
    {
        return $this->belongsTo(
            PerangkatDesa::class,
            'perangkat_desa_id'
        );
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(
            LaporanKinerjaFoto::class,
            'laporan_kinerja_id'
        )->orderBy('urutan')->orderBy('id');
    }
}