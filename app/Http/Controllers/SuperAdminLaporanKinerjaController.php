<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanKinerjaRequest;
use App\Http\Requests\UpdateLaporanKinerjaRequest;
use App\Http\Resources\LaporanKinerjaResource;
use App\Models\LaporanKinerja;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SuperAdminLaporanKinerjaController extends Controller
{
    /**
     * Relasi yang digunakan oleh resource.
     */
    private function laporanQuery()
    {
        return LaporanKinerja::query()
            ->with([
                'perangkatDesa:id,nama,jabatan',
                'fotos:id,laporan_kinerja_id,urutan',
            ]);
    }

    /**
     * GET /api/superadmin/laporan-kinerja
     *
     * Menampilkan seluruh laporan, termasuk draft.
     */
    public function index(): JsonResponse
    {
        $laporan = $this->laporanQuery()
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'message' =>
                'Daftar laporan kinerja berhasil diambil.',

            'data' =>
                LaporanKinerjaResource::collection($laporan),
        ]);
    }

    /**
     * POST /api/superadmin/laporan-kinerja
     *
     * Membuat laporan baru dengan status draft.
     * Foto dapat diunggah menggunakan field foto[].
     */
    public function store(
        StoreLaporanKinerjaRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $files = $request->file('foto', []) ?? [];

        if (! is_array($files)) {
            $files = [$files];
        }

        $files = array_values(
            array_filter($files)
        );

        unset($validated['foto']);

        $storedPaths = [];

        try {
            /*
            |--------------------------------------------------------------------------
            | SIMPAN FILE
            |--------------------------------------------------------------------------
            */

            foreach ($files as $file) {
                $path = $file->store(
                    'laporan-kinerja',
                    'local'
                );

                if (! is_string($path) || $path === '') {
                    throw new \RuntimeException(
                        'Gagal menyimpan foto laporan kinerja.'
                    );
                }

                $storedPaths[] = $path;
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN DATABASE
            |--------------------------------------------------------------------------
            */

            $laporan = DB::transaction(function () use (
                $validated,
                $storedPaths
            ) {
                $laporan = LaporanKinerja::create([
                    'judul' => $validated['judul'],
                    'kategori' => $validated['kategori'],
                    'tanggal' => $validated['tanggal'],
                    'deskripsi' => $validated['deskripsi'],
                    'lokasi' => $validated['lokasi'] ?? null,
                    'perangkat_desa_id' =>
                        $validated['perangkat_desa_id'] ?? null,
                    'status' => 'draft',
                ]);

                foreach ($storedPaths as $index => $path) {
                    $laporan->fotos()->create([
                        'file_path' => $path,
                        'urutan' => $index,
                    ]);
                }

                return $laporan;
            });
        } catch (Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | CLEANUP FILE JIKA PROSES GAGAL
            |--------------------------------------------------------------------------
            */

            if (! empty($storedPaths)) {
                Storage::disk('local')->delete(
                    $storedPaths
                );
            }

            report($e);

            return response()->json([
                'message' =>
                    'Gagal membuat laporan kinerja.',
            ], 500);
        }

        $laporan->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Laporan kinerja berhasil ditambahkan sebagai draft.',

            'data' =>
                new LaporanKinerjaResource($laporan),
        ], 201);
    }

    /**
     * GET /api/superadmin/laporan-kinerja/{laporanKinerja}
     *
     * Menampilkan detail laporan, termasuk draft.
     */
    public function show(
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        $laporanKinerja->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Detail laporan kinerja berhasil diambil.',

            'data' =>
                new LaporanKinerjaResource($laporanKinerja),
        ]);
    }

    /**
     * PUT/PATCH /api/superadmin/laporan-kinerja/{laporanKinerja}
     *
     * Memperbarui laporan.
     *
     * Upload foto baru:
     * foto[]
     *
     * Menghapus foto tertentu:
     * hapus_foto_ids[]
     */
    public function update(
        UpdateLaporanKinerjaRequest $request,
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        $validated = $request->validated();

        $hapusFotoIds = array_values(
            $validated['hapus_foto_ids'] ?? []
        );

        $files = $request->file('foto', []) ?? [];

        if (! is_array($files)) {
            $files = [$files];
        }

        $files = array_values(
            array_filter($files)
        );

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN FOTO MILIK LAPORAN INI
        |--------------------------------------------------------------------------
        */

        $fotosDihapus = $laporanKinerja
            ->fotos()
            ->whereIn('id', $hapusFotoIds)
            ->get([
                'id',
                'laporan_kinerja_id',
                'file_path',
                'urutan',
            ]);

        if ($fotosDihapus->count() !== count($hapusFotoIds)) {
            return response()->json([
                'message' =>
                    'Satu atau lebih foto tidak ditemukan pada laporan ini.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | PISAHKAN DATA LAPORAN DAN FOTO
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['foto'],
            $validated['hapus_foto_ids']
        );

        $storedPaths = [];

        try {
            /*
            |--------------------------------------------------------------------------
            | SIMPAN FOTO BARU TERLEBIH DAHULU
            |--------------------------------------------------------------------------
            */

            foreach ($files as $file) {
                $path = $file->store(
                    'laporan-kinerja',
                    'local'
                );

                if (! is_string($path) || $path === '') {
                    throw new \RuntimeException(
                        'Gagal menyimpan foto laporan kinerja.'
                    );
                }

                $storedPaths[] = $path;
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE DATABASE
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $laporanKinerja,
                $validated,
                $hapusFotoIds,
                $storedPaths
            ) {
                if (! empty($validated)) {
                    $laporanKinerja->fill(
                        $validated
                    );

                    $laporanKinerja->save();
                }

                /*
                |----------------------------------------------------------------------
                | HAPUS RELASI FOTO YANG DIPILIH
                |----------------------------------------------------------------------
                */

                if (! empty($hapusFotoIds)) {
                    $laporanKinerja
                        ->fotos()
                        ->whereIn('id', $hapusFotoIds)
                        ->delete();
                }

                /*
                |----------------------------------------------------------------------
                | TAMBAHKAN FOTO BARU
                |----------------------------------------------------------------------
                */

                $urutan = (
                    (int) (
                        $laporanKinerja
                            ->fotos()
                            ->max('urutan') ?? -1
                    )
                ) + 1;

                foreach ($storedPaths as $path) {
                    $laporanKinerja->fotos()->create([
                        'file_path' => $path,
                        'urutan' => $urutan++,
                    ]);
                }
            });
        } catch (Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | CLEANUP FOTO BARU JIKA GAGAL
            |--------------------------------------------------------------------------
            */

            if (! empty($storedPaths)) {
                Storage::disk('local')->delete(
                    $storedPaths
                );
            }

            report($e);

            return response()->json([
                'message' =>
                    'Gagal memperbarui laporan kinerja.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE FISIK FOTO LAMA
        |--------------------------------------------------------------------------
        |
        | File lama dihapus sesudah transaksi database berhasil.
        |
        */

        $oldPaths = $fotosDihapus
            ->pluck('file_path')
            ->filter()
            ->values()
            ->all();

        if (! empty($oldPaths)) {
            Storage::disk('local')->delete($oldPaths);
        }

        $laporanKinerja->refresh();

        $laporanKinerja->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Laporan kinerja berhasil diperbarui.',

            'data' =>
                new LaporanKinerjaResource($laporanKinerja),
        ]);
    }

    /**
     * DELETE /api/superadmin/laporan-kinerja/{laporanKinerja}
     *
     * Menghapus laporan beserta semua foto dokumentasinya.
     */
    public function destroy(
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        $fotoPaths = $laporanKinerja
            ->fotos()
            ->pluck('file_path')
            ->filter()
            ->values()
            ->all();

        try {
            DB::transaction(function () use (
                $laporanKinerja
            ) {
                $laporanKinerja->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' =>
                    'Gagal menghapus laporan kinerja.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE FISIK
        |--------------------------------------------------------------------------
        */

        if (! empty($fotoPaths)) {
            Storage::disk('local')->delete($fotoPaths);
        }

        return response()->json([
            'message' =>
                'Laporan kinerja beserta foto dokumentasinya berhasil dihapus.',

            'data' => null,
        ]);
    }

    /**
     * PATCH /api/superadmin/laporan-kinerja/{laporanKinerja}/publish
     *
     * Memublikasikan laporan.
     */
    public function publish(
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        $laporanKinerja->status = 'published';
        $laporanKinerja->save();

        $laporanKinerja->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Laporan kinerja berhasil dipublikasikan.',

            'data' =>
                new LaporanKinerjaResource($laporanKinerja),
        ]);
    }

    /**
     * PATCH /api/superadmin/laporan-kinerja/{laporanKinerja}/unpublish
     *
     * Menarik publikasi dan mengubah status menjadi draft.
     */
    public function unpublish(
        LaporanKinerja $laporanKinerja
    ): JsonResponse {
        $laporanKinerja->status = 'draft';
        $laporanKinerja->save();

        $laporanKinerja->load([
            'perangkatDesa:id,nama,jabatan',
            'fotos:id,laporan_kinerja_id,urutan',
        ]);

        return response()->json([
            'message' =>
                'Publikasi laporan kinerja berhasil ditarik.',

            'data' =>
                new LaporanKinerjaResource($laporanKinerja),
        ]);
    }
}