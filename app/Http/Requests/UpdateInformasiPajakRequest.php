<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInformasiPajakRequest extends FormRequest
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
                    'pbb_p2',
                    'tata_cara_pembayaran',
                    'pengumuman_pajak',
                ]),
            ],

            'isi' => [
                'required',
                'string',
            ],

            'tanggal_publikasi' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'string',
                Rule::in([
                    'draft',
                    'published',
                    'archived',
                ]),
            ],
        ];
    }
}