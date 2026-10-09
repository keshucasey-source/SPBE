<?php

namespace App\Http\Controllers;

use App\Http\Resources\LaporanKinerjaResource;
use App\Models\LaporanKinerja;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LaporanKinerjaController extends Controller
{
    /**
     * Menampilkan daftar laporan kinerja yang sudah dipublikasikan.
     *
     * GET /api/laporan-kinerja
     * GET /api/laporan-kinerja?tahun=2026
     * GET /api/laporan-kinerja?tahun=2026&kategori=pembangunan
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tahun' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1900',
                'max:9999',
            ],

            'kategori' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in([
                    'pembangunan',
                    'pemberdayaan',
                    'peresmian',
                    'sosial',
                    'pemerintahan',
                    'prestasi',
                ]),
            ],
        ]);

        $laporanKinerja = LaporanKinerja::query()
            ->with([
                'perangkatDesa:id,nama,jabatan',
                'fotos:id,laporan_kinerja_id,urutan',
            ])
            ->where('status', 'published')

            ->when(
                ! empty($validated['tahun']),
                function ($query) use ($validated) {
                    $query->whereYear(
                        'tanggal',
                        $validated['tahun']
                    );
                }
            )

            ->when(
                ! empty($validated['kategori']),
                function ($query) use ($validated) {
                    $query->where(
                        'kategori',
                        $validated['kategori']
                    );
                }
            )

            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'message' =>
                'Daftar laporan kinerja berhasil diambil.',

            'data' =>
                LaporanKinerjaResource::collection(
                    $laporanKinerja
                ),
        ]);
    }

    /**
     * Menampilkan detail laporan kinerja yang sudah dipublikasikan.
     *
     * GET /api/laporan-kinerja/{laporanKinerja}
     */
    public function show(
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        abort_unless(
            $laporanKinerja->status === 'published',
            404,
            'Laporan kinerja tidak ditemukan.'
        );

        $laporanKinerja->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Detail laporan kinerja berhasil diambil.',

            'data' =>
                new LaporanKinerjaResource(
                    $laporanKinerja
                ),
        ]);
    }
}