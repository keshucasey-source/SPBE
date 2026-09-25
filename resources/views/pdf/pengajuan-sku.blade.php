<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Tiket Pengajuan SKU - {{ $pengajuan->no_antrian }}
    </title>

    <style>
        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            font-size: 12px;
            line-height: 1.5;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .header-subtitle {
            font-size: 13px;
            font-weight: bold;
        }

        .header-description {
            font-size: 10px;
            margin-top: 4px;
            color: #555;
        }

        .ticket-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .ticket-number-box {
            border: 2px solid #222;
            text-align: center;
            padding: 12px;
            margin-bottom: 20px;
        }

        .ticket-number-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 4px;
        }

        .ticket-number {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            background: #eeeeee;
            border-left: 4px solid #222;
            padding: 7px 9px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 5px;
            vertical-align: top;
        }

        .label {
            width: 35%;
            font-weight: bold;
        }

        .separator {
            width: 3%;
            text-align: center;
        }

        .value {
            width: 62%;
        }

        .status {
            border: 1px solid #222;
            text-align: center;
            padding: 8px;
            font-weight: bold;
            font-size: 13px;
            margin-top: 5px;
        }

        .notice {
            border: 1px solid #999;
            padding: 10px;
            margin-top: 18px;
            font-size: 10px;
            color: #444;
        }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }

        .signature {
            margin-top: 35px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
        }

        .signature-left {
            width: 55%;
        }

        .signature-right {
            width: 45%;
            text-align: center;
        }

        .signature-space {
            height: 55px;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Header --}}
    <div class="header">

        <div class="header-title">
            PEMERINTAH DESA SUMBERPORONG
        </div>

        <div class="header-subtitle">
            TIKET PELAYANAN MASYARAKAT
        </div>

        <div class="header-description">
            Sistem Pelayanan Berbasis Elektronik Desa Sumberporong
        </div>

    </div>

    {{-- Title --}}
    <div class="ticket-title">
        Tiket Pengajuan SKU
    </div>

    {{-- Nomor Tiket --}}
    <div class="ticket-number-box">

        <div class="ticket-number-label">
            Nomor Antrean
        </div>

        <div class="ticket-number">
            {{ $pengajuan->no_antrian }}
        </div>

    </div>

    {{-- Data Pemohon --}}
    <div class="section">

        <div class="section-title">
            DATA PEMOHON
        </div>

        <table>

            <tr>
                <td class="label">
                    Nama Lengkap
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->nama_lengkap }}
                </td>
            </tr>

            <tr>
                <td class="label">
                    Tempat, Tanggal Lahir
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">

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
                <td class="label">
                    Jenis Kelamin
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->jenis_kelamin === 'L'
                        ? 'Laki-laki'
                        : 'Perempuan' }}
                </td>
            </tr>

        </table>

    </div>

    {{-- Data Usaha --}}
    <div class="section">

        <div class="section-title">
            DATA USAHA
        </div>

        <table>

            <tr>
                <td class="label">
                    Nama Usaha
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->nama_usaha }}
                </td>
            </tr>

            <tr>
                <td class="label">
                    Jenis Usaha
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->jenis_usaha }}
                </td>
            </tr>

            <tr>
                <td class="label">
                    Alamat Usaha
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->alamat_usaha }}
                </td>
            </tr>

            <tr>
                <td class="label">
                    RT / RW Usaha
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->rt_usaha }}
                    /
                    {{ $pengajuan->rw_usaha }}
                </td>
            </tr>

            <tr>
                <td class="label">
                    Lama Menjalankan Usaha
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    {{ $pengajuan->lama_menjalankan_usaha }}
                    tahun
                </td>
            </tr>

            <tr>
                <td class="label">
                    Perkiraan Penghasilan / Bulan
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    Rp
                    {{ number_format(
                        $pengajuan->perkiraan_penghasilan_per_bulan,
                        0,
                        ',',
                        '.'
                    ) }}
                </td>
            </tr>

        </table>

    </div>

    {{-- Jadwal Pelayanan --}}
    <div class="section">

        <div class="section-title">
            JADWAL PELAYANAN
        </div>

        <table>

            <tr>
                <td class="label">
                    Tanggal Kunjungan
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">

                    {{ $pengajuan->visit_date
                        ? $pengajuan->visit_date
                            ->locale('id')
                            ->translatedFormat('l, d F Y')
                        : '-' }}

                </td>
            </tr>

            <tr>
                <td class="label">
                    Jam Pelayanan
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">
                    08.30 - 13.00 WIB
                </td>
            </tr>

            <tr>
                <td class="label">
                    Tanggal Approval
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">

                    {{ $pengajuan->approved_at
                        ? $pengajuan->approved_at
                            ->locale('id')
                            ->translatedFormat('d F Y, H:i') . ' WIB'
                        : '-' }}

                </td>
            </tr>

            <tr>
                <td class="label">
                    Berlaku Sampai
                </td>

                <td class="separator">
                    :
                </td>

                <td class="value">

                    {{ $pengajuan->expired_at
                        ? $pengajuan->expired_at
                            ->locale('id')
                            ->translatedFormat('d F Y, H:i') . ' WIB'
                        : '-' }}

                </td>
            </tr>

        </table>

    </div>

    {{-- Status --}}
    <div class="section">

        <div class="section-title">
            STATUS PENGAJUAN
        </div>

        <div class="status">
            DISETUJUI
        </div>

    </div>

    {{-- Catatan --}}
    <div class="notice">

        <strong>Catatan:</strong><br>

        Harap membawa dokumen persyaratan yang diperlukan
        ketika datang ke kantor desa sesuai dengan jadwal
        pelayanan yang tercantum pada tiket ini.

        Tiket ini merupakan bukti bahwa pengajuan SKU
        telah disetujui dan memiliki jadwal pelayanan.

    </div>

    {{-- Signature --}}
    <div class="signature">

        <table class="signature-table">

            <tr>

                <td class="signature-left">
                </td>

                <td class="signature-right">

                    Desa Sumberporong

                    <div class="signature-space">
                    </div>

                    <strong>
                        Petugas Pelayanan
                    </strong>

                </td>

            </tr>

        </table>

    </div>

    {{-- Footer --}}
    <div class="footer">

        Dokumen ini dibuat secara elektronik melalui
        Sistem Pelayanan Berbasis Elektronik Desa Sumberporong.

        <br>

        Nomor tiket:
        {{ $pengajuan->no_antrian }}

    </div>

</div>

</body>
</html>