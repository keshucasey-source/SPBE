<?php

namespace App\Http\Controllers;

use App\Http\Resources\FasilitasResource;
use App\Models\Fasilitas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminFasilitasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | GET /api/admin/fasilitas
    |
    */

    public function index(): JsonResponse
    {
        $fasilitas =
            Fasilitas::query()
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
    | STORE
    |--------------------------------------------------------------------------
    |
    | POST /api/admin/fasilitas
    |
    */

    public function store(
        Request $request
    ): JsonResponse {
        $validated =
            $request->validate([
                'nama' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'kategori' => [
                    'required',
                    'string',
                    'in:pemerintahan,kesehatan,pendidikan,keagamaan,fasilitas_umum',
                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                ],

                'alamat' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'foto' => [
                    'required',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],

                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],

                'is_active' => [
                    'nullable',
                    'boolean',
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN FOTO
        |--------------------------------------------------------------------------
        */

        $fotoPath =
            $request
                ->file('foto')
                ->store(
                    'fasilitas',
                    'local'
                );

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        $fasilitas =
            Fasilitas::create([
                'nama' =>
                    $validated['nama'],

                'kategori' =>
                    $validated['kategori'],

                'deskripsi' =>
                    $validated['deskripsi'] ?? null,

                'alamat' =>
                    $validated['alamat'],

                'foto' =>
                    $fotoPath,

                'urutan' =>
                    $validated['urutan'] ?? 0,

                'is_active' =>
                    array_key_exists(
                        'is_active',
                        $validated
                    )
                        ? (bool) $validated['is_active']
                        : true,
            ]);

        return response()->json([
            'message' =>
                'Fasilitas berhasil ditambahkan.',

            'data' =>
                new FasilitasResource(
                    $fasilitas
                ),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    |
    | GET /api/admin/fasilitas/{fasilitas}
    |
    */

    public function show(
        Fasilitas $fasilitas
    ): JsonResponse {
        return response()->json([
            'message' =>
                'Detail fasilitas berhasil diambil.',

            'data' =>
                new FasilitasResource(
                    $fasilitas
                ),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | POST /api/admin/fasilitas/{fasilitas}
    |
    | Foto baru OPTIONAL.
    |
    | Kalau foto tidak dikirim:
    | foto lama tetap digunakan.
    |
    */

    public function update(
        Request $request,
        Fasilitas $fasilitas
    ): JsonResponse {
        $validated =
            $request->validate([
                'nama' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'kategori' => [
                    'required',
                    'string',
                    'in:pemerintahan,kesehatan,pendidikan,keagamaan,fasilitas_umum',
                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                ],

                'alamat' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'foto' => [
                    'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],

                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],

                'is_active' => [
                    'nullable',
                    'boolean',
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | DATA DASAR
        |--------------------------------------------------------------------------
        */

        $fasilitas->nama =
            $validated['nama'];

        $fasilitas->kategori =
            $validated['kategori'];

        $fasilitas->deskripsi =
            $validated['deskripsi'] ?? null;

        $fasilitas->alamat =
            $validated['alamat'];

        if (
            array_key_exists(
                'urutan',
                $validated
            )
        ) {
            $fasilitas->urutan =
                $validated['urutan'];
        }

        if (
            array_key_exists(
                'is_active',
                $validated
            )
        ) {
            $fasilitas->is_active =
                (bool) $validated['is_active'];
        }

        /*
        |--------------------------------------------------------------------------
        | FOTO BARU
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('foto')
        ) {
            /*
            |--------------------------------------------------------------------------
            | Simpan foto baru terlebih dahulu
            |--------------------------------------------------------------------------
            */

            $newFotoPath =
                $request
                    ->file('foto')
                    ->store(
                        'fasilitas',
                        'local'
                    );

            $oldFotoPath =
                $fasilitas->foto;

            $fasilitas->foto =
                $newFotoPath;

            /*
            |--------------------------------------------------------------------------
            | Hapus foto lama
            |--------------------------------------------------------------------------
            */

            if (
                filled($oldFotoPath) &&
                Storage::disk('local')
                    ->exists($oldFotoPath)
            ) {
                Storage::disk('local')
                    ->delete(
                        $oldFotoPath
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $fasilitas->save();

        return response()->json([
            'message' =>
                'Fasilitas berhasil diperbarui.',

            'data' =>
                new FasilitasResource(
                    $fasilitas
                ),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    |
    | DELETE /api/admin/fasilitas/{fasilitas}
    |
    */

    public function destroy(
        Fasilitas $fasilitas
    ): JsonResponse {
        /*
        |--------------------------------------------------------------------------
        | HAPUS FOTO
        |--------------------------------------------------------------------------
        */

        if (
            filled($fasilitas->foto) &&
            Storage::disk('local')
                ->exists(
                    $fasilitas->foto
                )
        ) {
            Storage::disk('local')
                ->delete(
                    $fasilitas->foto
                );
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATABASE
        |--------------------------------------------------------------------------
        */

        $fasilitas->delete();

        return response()->json([
            'message' =>
                'Fasilitas berhasil dihapus.',

            'data' =>
                null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE ACTIVE
    |--------------------------------------------------------------------------
    |
    | PATCH /api/admin/fasilitas/{fasilitas}/active
    |
    */

    public function toggleActive(
        Fasilitas $fasilitas
    ): JsonResponse {
        $fasilitas->is_active =
            ! $fasilitas->is_active;

        $fasilitas->save();

        return response()->json([
            'message' =>
                $fasilitas->is_active
                    ? 'Fasilitas berhasil diaktifkan.'
                    : 'Fasilitas berhasil dinonaktifkan.',

            'data' =>
                new FasilitasResource(
                    $fasilitas
                ),
        ]);
    }
}