<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPajak extends Model
{
    use HasFactory;

    protected $table = 'informasi_pajaks';

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'tanggal_publikasi',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'date',
        ];
    }
}