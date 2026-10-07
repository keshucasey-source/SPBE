<?php

namespace App\Http\Controllers;

use App\Http\Resources\InformasiPajakResource;
use App\Models\InformasiPajak;
use Illuminate\Http\JsonResponse;

class InformasiPajakController extends Controller
{
    /**
     * Menampilkan informasi pajak yang sudah dipublikasikan.
     */
    public function index(): JsonResponse
    {
        $informasiPajak = InformasiPajak::query()
            ->where('status', 'published')
            ->orderByDesc('tanggal_publikasi')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'message' => 'Daftar informasi pajak berhasil diambil.',
            'data' => InformasiPajakResource::collection(
                $informasiPajak
            ),
        ]);
    }

    /**
     * Menampilkan detail informasi pajak.
     */
    public function show(
        InformasiPajak $informasiPajak
    ): JsonResponse {
        abort_unless(
            $informasiPajak->status === 'published',
            404,
            'Informasi pajak tidak ditemukan.'
        );

        return response()->json([
            'message' => 'Detail informasi pajak berhasil diambil.',
            'data' => new InformasiPajakResource(
                $informasiPajak
            ),
        ]);
    }
}