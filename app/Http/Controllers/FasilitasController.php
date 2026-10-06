<?php

namespace App\Http\Controllers;

use App\Http\Resources\FasilitasResource;
use App\Models\Fasilitas;
use Illuminate\Http\JsonResponse;

class FasilitasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | GET /api/fasilitas
    |
    */

    public function index(): JsonResponse
    {
        $fasilitas =
            Fasilitas::query()
                ->where('is_active', true)
                ->orderBy('kategori')
                ->orderBy('urutan')
                ->orderBy('id')
                ->get();

        return response()->json([
            'message' =>
                'Daftar fasilitas berhasil diambil.',

            'data' =>
                FasilitasResource::collection(
                    $fasilitas
                ),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    |
    | GET /api/fasilitas/{fasilitas}
    |
    */

    public function show(
        Fasilitas $fasilitas
    ): JsonResponse {
        abort_unless(
            $fasilitas->is_active,
            404,
            'Fasilitas tidak ditemukan.'
        );

        return response()->json([
            'message' =>
                'Detail fasilitas berhasil diambil.',

            'data' =>
                new FasilitasResource(
                    $fasilitas
                ),
        ]);
    }
}