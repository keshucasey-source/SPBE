<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaporanKinerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => [
                'required',
                'string',
                'max:150',
            ],

            'kategori' => [
                'required',
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

            'tanggal' => [
                'required',
                'date',
            ],

            'deskripsi' => [
                'required',
                'string',
            ],

            'lokasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'perangkat_desa_id' => [
                'nullable',
                'integer',
                'exists:perangkat_desa,id',
            ],

            'foto' => [
                'nullable',
                'array',
                'max:20',
            ],

            'foto.*' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' =>
                'Judul laporan wajib diisi.',

            'judul.max' =>
                'Judul laporan maksimal 150 karakter.',

            'kategori.required' =>
                'Kategori laporan wajib dipilih.',

            'kategori.in' =>
                'Kategori laporan tidak valid.',

            'tanggal.required' =>
                'Tanggal kegiatan wajib diisi.',

            'tanggal.date' =>
                'Tanggal kegiatan tidak valid.',

            'deskripsi.required' =>
                'Deskripsi laporan wajib diisi.',

            'lokasi.max' =>
                'Lokasi maksimal 255 karakter.',

            'perangkat_desa_id.exists' =>
                'Perangkat desa yang dipilih tidak ditemukan.',

            'foto.array' =>
                'Format unggahan foto tidak valid.',

            'foto.max' =>
                'Foto laporan maksimal 20 file dalam satu unggahan.',

            'foto.*.required' =>
                'Setiap foto laporan wajib berupa file.',

            'foto.*.image' =>
                'Setiap dokumen foto harus berupa gambar.',

            'foto.*.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'foto.*.max' =>
                'Ukuran setiap foto maksimal 5 MB.',
        ];
    }
}