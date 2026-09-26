<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Formulir Pengajuan SKU - {{ $pengajuan->no_antrian }}
    </title>

    <style>
        @page {
            size: A4;
            margin: 25px 28px 25px 28px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #000;
            font-size: 9px;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
        }

        /* =========================================================
           HEADER
           ========================================================== */

        .header {
            position: relative;
            text-align: center;
            margin-bottom: 8px;
        }

        .form-code {
            position: absolute;
            top: 0;
            right: 0;
            border: 1px solid #000;
            padding: 3px 7px;
            font-size: 11px;
            font-weight: bold;
        }

        .header-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 3px;
        }

        .header-subtitle {
            font-size: 10px;
            font-weight: bold;
            margin-top: 2px;
        }

        .header-description {
            font-size: 8px;
            margin-top: 2px;
        }

        /* =========================================================
           BOX
           ========================================================== */

        .box {
            border: 1px solid #000;
            width: 100%;
        }

        .box-title {
            font-weight: bold;
            padding: 4px 6px;
            border-bottom: 1px solid #000;
            background: #f4f4f4;
        }

        .box-content {
            padding: 5px 7px;
        }

        /* =========================================================
           PETUNJUK
           ========================================================== */

        .instruction {
            margin-top: 7px;
            margin-bottom: 8px;
        }

        .instruction ol {
            margin: 0;
            padding-left: 18px;
        }

        .instruction li {
            margin-bottom: 1px;
        }

        /* =========================================================
           CHECKBOX
           ========================================================== */

        .checkbox-table {
            width: 100%;
            border-collapse: collapse;
        }

        .checkbox-table td {
            padding: 2px 4px;
            vertical-align: middle;
        }

        .checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            vertical-align: middle;
            margin-right: 4px;
        }

        .checked {
            position: relative;
        }

        .checked:after {
            content: "✓";
            font-size: 10px;
            font-weight: bold;
            position: absolute;
            left: 1px;
            top: -2px;
        }

        /* =========================================================
           FORM TABLE
           ========================================================== */

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table th,
        .form-table td {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: top;
        }

        .form-table th {
            text-align: center;
            font-weight: bold;
        }

        .number-column {
            width: 5%;
            text-align: center;
        }

        .field-column {
            width: 29%;
            font-weight: bold;
        }

        .value-column {
            width: 66%;
        }

        /* =========================================================
           TICKET / PELAYANAN
           ========================================================== */

        .service-table {
            width: 100%;
            border-collapse: collapse;
        }

        .service-table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .service-label {
            width: 28%;
            font-weight: bold;
        }

        .service-value {
            width: 72%;
        }

        .ticket-box {
            border: 2px solid #000;
            text-align: center;
            padding: 7px 5px;
            margin-top: 7px;
            margin-bottom: 7px;
        }

        .ticket-label {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .ticket-number {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* =========================================================
           STATUS
           ========================================================== */

        .status-box {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            margin-top: 7px;
        }

        /* =========================================================
           CATATAN
           ========================================================== */

        .note {
            border: 1px solid #000;
            margin-top: 8px;
            padding: 6px 7px;
            font-size: 8px;
        }

        /* =========================================================
           TANDA TANGAN
           ========================================================== */

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 4px;
        }

        .signature-space {
            height: 48px;
        }

        /* =========================================================
           FOOTER
           ========================================================== */

        .footer {
            margin-top: 8px;
            text-align: center;
            font-size: 7px;
        }
    </style>
</head>

<body>

<div class="page">

    {{-- =========================================================
         HEADER
         ========================================================== --}}

    <div class="header">

        <div class="form-code">
            SPBE-SKU
        </div>

        <div class="header-title">
            PEMERINTAH DESA SUMBERPORONG
        </div>

        <div class="header-subtitle">
            FORMULIR PENGAJUAN SURAT KETERANGAN USAHA
        </div>

        <div class="header-description">
            Sistem Pelayanan Berbasis Elektronik Desa Sumberporong
        </div>

    </div>

    {{-- =========================================================
         PETUNJUK
         ========================================================== --}}

    <div class="box instruction">

        <div class="box-title">
            PETUNJUK
        </div>

        <div class="box-content">

            <ol>
                <li>
                    Harap isi dan periksa data dengan benar dan lengkap.
                </li>

                <li>
                    Dokumen persyaratan harus sesuai dengan ketentuan pelayanan.
                </li>

                <li>
                    Pemohon wajib hadir sesuai jadwal pelayanan yang tercantum pada tiket.
                </li>
            </ol>

        </div>

    </div>

    {{-- =========================================================
         DATA PEMOHON
         ========================================================== --}}

    <div class="box">

        <div class="box-title">
            DATA PEMOHON
        </div>

        <div class="box-content" style="padding: 0;">

            <table class="form-table">

                <tr>

                    <td class="number-column">
                        1
                    </td>

                    <td class="field-column">
                        NAMA LENGKAP
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->nama_lengkap }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        2
                    </td>

                    <td class="field-column">
                        NIK
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->nik }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        3
                    </td>

                    <td class="field-column">
                        NOMOR KARTU KELUARGA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->nomor_kk }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        4
                    </td>

                    <td class="field-column">
                        TEMPAT, TANGGAL LAHIR
                    </td>

                    <td class="value-column">

                        {{ $pengajuan->tempat_lahir }}

                        @if ($pengajuan->tanggal_lahir)
                            ,
                            {{ $pengajuan->tanggal_lahir
                                ->locale('id')
                                ->translatedFormat('d F Y') }}
                        @endif

                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        5
                    </td>

                    <td class="field-column">
                        JENIS KELAMIN
                    </td>

                    <td class="value-column">

                        <span class="checkbox
                            {{ $pengajuan->jenis_kelamin === 'L' ? 'checked' : '' }}">
                        </span>

                        Laki-laki

                        &nbsp;&nbsp;&nbsp;

                        <span class="checkbox
                            {{ $pengajuan->jenis_kelamin === 'P' ? 'checked' : '' }}">
                        </span>

                        Perempuan

                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        6
                    </td>

                    <td class="field-column">
                        ALAMAT
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->alamat }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        7
                    </td>

                    <td class="field-column">
                        RT / RW
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->rt }}
                        /
                        {{ $pengajuan->rw }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        8
                    </td>

                    <td class="field-column">
                        KODE POS
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->kode_pos }}
                    </td>

                </tr>

            </table>

        </div>

    </div>

    {{-- =========================================================
         DATA USAHA
         ========================================================== --}}

    <div class="box" style="margin-top: 8px;">

        <div class="box-title">
            DATA USAHA
        </div>

        <div class="box-content" style="padding: 0;">

            <table class="form-table">

                <tr>

                    <td class="number-column">
                        1
                    </td>

                    <td class="field-column">
                        NAMA USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->nama_usaha }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        2
                    </td>

                    <td class="field-column">
                        JENIS USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->jenis_usaha }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        3
                    </td>

                    <td class="field-column">
                        DESKRIPSI USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->deskripsi_usaha }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        4
                    </td>

                    <td class="field-column">
                        ALAMAT USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->alamat_usaha }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        5
                    </td>

                    <td class="field-column">
                        RT / RW USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->rt_usaha }}
                        /
                        {{ $pengajuan->rw_usaha }}
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        6
                    </td>

                    <td class="field-column">
                        LAMA MENJALANKAN USAHA
                    </td>

                    <td class="value-column">
                        {{ $pengajuan->lama_menjalankan_usaha }}
                        tahun
                    </td>

                </tr>

                <tr>

                    <td class="number-column">
                        7
                    </td>

                    <td class="field-column">
                        PERKIRAAN PENGHASILAN / BULAN
                    </td>

                    <td class="value-column">

                        Rp
                        {{ number_format(
                            (float) $pengajuan->perkiraan_penghasilan_per_bulan,
                            0,
                            ',',
                            '.'
                        ) }}

                    </td>

                </tr>

            </table>

        </div>

    </div>

    {{-- =========================================================
         DATA PELAYANAN
         ========================================================== --}}

    <div class="box" style="margin-top: 8px;">

        <div class="box-title">
            DATA PELAYANAN
        </div>

        <div class="box-content">

            <div class="ticket-box">

                <div class="ticket-label">
                    NOMOR ANTREAN
                </div>

                <div class="ticket-number">
                    {{ $pengajuan->no_antrian }}
                </div>

            </div>

            <table class="service-table">

                <tr>

                    <td class="service-label">
                        Status Pengajuan
                    </td>

                    <td class="service-value">
                        DISETUJUI
                    </td>

                </tr>

                <tr>

                    <td class="service-label">
                        Tanggal Approval
                    </td>

                    <td class="service-value">

                        {{ $pengajuan->approved_at
                            ? $pengajuan->approved_at
                                ->locale('id')
                                ->translatedFormat('d F Y, H:i') . ' WIB'
                            : '-' }}

                    </td>

                </tr>

                <tr>

                    <td class="service-label">
                        Tanggal Kunjungan
                    </td>

                    <td class="service-value">

                        {{ $pengajuan->visit_date
                            ? $pengajuan->visit_date
                                ->locale('id')
                                ->translatedFormat('l, d F Y')
                            : '-' }}

                    </td>

                </tr>

                <tr>

                    <td class="service-label">
                        Jam Pelayanan
                    </td>

                    <td class="service-value">
                        08.30 - 13.00 WIB
                    </td>

                </tr>

                <tr>

                    <td class="service-label">
                        Berlaku Sampai
                    </td>

                    <td class="service-value">

                        {{ $pengajuan->expired_at
                            ? $pengajuan->expired_at
                                ->locale('id')
                                ->translatedFormat('d F Y, H:i') . ' WIB'
                            : '-' }}

                    </td>

                </tr>

            </table>

            <div class="status-box">
                PENGAJUAN TELAH DISETUJUI
            </div>

        </div>

    </div>

    {{-- =========================================================
         CATATAN
         ========================================================== --}}

    <div class="note">

        <strong>CATATAN:</strong>

        <ol style="margin: 3px 0 0 15px; padding: 0;">

            <li>
                Pemohon wajib membawa dokumen persyaratan asli saat datang ke kantor desa.
            </li>

            <li>
                Pemohon wajib hadir pada tanggal dan jam pelayanan yang tercantum dalam formulir ini.
            </li>

            <li>
                Tiket ini merupakan bukti persetujuan pengajuan SKU dan bukan merupakan dokumen SKU.
            </li>

        </ol>

    </div>

    {{-- =========================================================
         TANDA TANGAN
         ========================================================== --}}

    <table class="signature-table">

        <tr>

            <td>

                Pemohon,

                <div class="signature-space">
                </div>

                <strong>
                    {{ $pengajuan->nama_lengkap }}
                </strong>

            </td>

            <td>

                Mengetahui,

                <br>

                Petugas Pelayanan Desa Sumberporong

                <div class="signature-space">
                </div>

                <strong>
                    Petugas Pelayanan
                </strong>

            </td>

        </tr>

    </table>

    {{-- =========================================================
         FOOTER
         ========================================================== --}}

    <div class="footer">

        Dokumen ini dibuat secara elektronik melalui
        Sistem Pelayanan Berbasis Elektronik Desa Sumberporong.

        <br>

        Nomor antrean:
        {{ $pengajuan->no_antrian }}

    </div>

</div>

</body>
</html>