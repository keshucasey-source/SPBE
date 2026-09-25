<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKtp;
use App\Models\PengajuanSku;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PengajuanPdfController extends Controller
{
    /**
     * Cetak PDF tiket pengajuan KTP.
     */
    public function ktp(
        PengajuanKtp $pengajuanKtp
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | Ownership Check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $pengajuanKtp->user_id === auth()->id(),
            403,
            'Anda tidak memiliki akses ke pengajuan ini.'
        );

        /*
        |--------------------------------------------------------------------------
        | Status Check
        |--------------------------------------------------------------------------
        |
        | PDF tiket hanya dapat dicetak jika
        | pengajuan sudah disetujui.
        |
        */

        abort_unless(
            $pengajuanKtp->status === 'disetujui',
            422,
            'Tiket PDF hanya dapat dicetak untuk pengajuan KTP yang sudah disetujui.'
        );

        /*
        |--------------------------------------------------------------------------
        | Load Relationship
        |--------------------------------------------------------------------------
        */

        $pengajuanKtp->load('user');

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'pdf.pengajuan-ktp',
            [
                'pengajuan' => $pengajuanKtp,
            ]
        );

        return $pdf
            ->setPaper('A4')
            ->stream(
                'tiket-pengajuan-ktp-' .
                $pengajuanKtp->no_antrian .
                '.pdf'
            );
    }

    /**
     * Cetak PDF tiket pengajuan SKU.
     */
    public function sku(
        PengajuanSku $pengajuanSku
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | Ownership Check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $pengajuanSku->user_id === auth()->id(),
            403,
            'Anda tidak memiliki akses ke pengajuan ini.'
        );

        /*
        |--------------------------------------------------------------------------
        | Status Check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $pengajuanSku->status === 'disetujui',
            422,
            'Tiket PDF hanya dapat dicetak untuk pengajuan SKU yang sudah disetujui.'
        );

        /*
        |--------------------------------------------------------------------------
        | Load Relationship
        |--------------------------------------------------------------------------
        */

        $pengajuanSku->load('user');

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'pdf.pengajuan-sku',
            [
                'pengajuan' => $pengajuanSku,
            ]
        );

        return $pdf
            ->setPaper('A4')
            ->stream(
                'tiket-pengajuan-sku-' .
                $pengajuanSku->no_antrian .
                '.pdf'
            );
    }
}