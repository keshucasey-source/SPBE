<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInformasiPajakRequest;
use App\Http\Requests\UpdateInformasiPajakRequest;
use App\Http\Resources\InformasiPajakResource;
use App\Models\InformasiPajak;
use Illuminate\Http\JsonResponse;

class AdminInformasiPajakController extends Controller
{
    /**
     * Menampilkan seluruh informasi pajak.
     */
    public function index(): JsonResponse
    {
        $informasiPajak = InformasiPajak::query()
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
     * Menambahkan informasi pajak.
     */
    public function store(
        StoreInformasiPajakRequest $request
    ): JsonResponse {
        $informasiPajak = InformasiPajak::create(
            $request->validated()
        );

        return response()->json([
            'message' =>
                'Informasi pajak berhasil ditambahkan.',
            'data' =>
                new InformasiPajakResource(
                    $informasiPajak
                ),
        ], 201);
    }

    /**
     * Menampilkan detail informasi pajak.
     */
    public function show(
        InformasiPajak $informasiPajak
    ): JsonResponse {
        return response()->json([
            'message' =>
                'Detail informasi pajak berhasil diambil.',
            'data' =>
                new InformasiPajakResource(
                    $informasiPajak
                ),
        ]);
    }

    /**
     * Memperbarui informasi pajak.
     */
    public function update(
        UpdateInformasiPajakRequest $request,
        InformasiPajak $informasiPajak
    ): JsonResponse {
        $informasiPajak->update(
            $request->validated()
        );

        return response()->json([
            'message' =>
                'Informasi pajak berhasil diperbarui.',
            'data' =>
                new InformasiPajakResource(
                    $informasiPajak->fresh()
                ),
        ]);
    }

    /**
     * Menghapus informasi pajak.
     */
    public function destroy(
        InformasiPajak $informasiPajak
    ): JsonResponse {
        $informasiPajak->delete();

        return response()->json([
            'message' =>
                'Informasi pajak berhasil dihapus.',
        ]);
    }
}