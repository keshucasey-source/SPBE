<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanKinerjaResource extends JsonResource
{
    /**
     * Mengubah data laporan kinerja menjadi response API.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'judul' => $this->judul,

            'kategori' => $this->kategori,

            'tanggal' => $this->tanggal?->format('Y-m-d'),

            'deskripsi' => $this->deskripsi,

            'lokasi' => $this->lokasi,

            'perangkat_desa_id' => $this->perangkat_desa_id,

            /*
            |--------------------------------------------------------------------------
            | DATA PERANGKAT DESA
            |--------------------------------------------------------------------------
            |
            | Nama dan jabatan diambil dari relasi PerangkatDesa.
            | Tidak menyimpan ulang data perangkat di tabel laporan.
            |
            */

            'nama_perangkat' => $this->whenLoaded(
                'perangkatDesa',
                fn () => $this->perangkatDesa?->nama
            ),

            'jabatan_perangkat' => $this->whenLoaded(
                'perangkatDesa',
                fn () => $this->perangkatDesa?->jabatan
            ),

            /*
            |--------------------------------------------------------------------------
            | FOTO DOKUMENTASI
            |--------------------------------------------------------------------------
            |
            | Foto dikembalikan sebagai array URL publik atau URL superadmin.
            | Foto draft menggunakan endpoint khusus superadmin.
            | Foto published menggunakan endpoint publik.
            |
            */

            'foto_urls' => $this->whenLoaded(
                'fotos',
                fn () => $this->fotos
                    ->map(function ($foto) {
                        $routeName = $this->status === 'published'
                            ? 'public.files.laporan-kinerja-foto'
                            : 'superadmin.files.laporan-kinerja-foto';

                        return route(
                            $routeName,
                            ['foto' => $foto->id]
                        );
                    })
                    ->values()
                    ->all(),
                []
            ),

            /*
            |--------------------------------------------------------------------------
            | STATUS DAN TIMESTAMPS
            |--------------------------------------------------------------------------
            |
            | Status dibutuhkan untuk pengelolaan oleh superadmin.
            |
            */

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}