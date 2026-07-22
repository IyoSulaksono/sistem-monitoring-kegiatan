<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Kegiatan - Diskominfo Kota Medan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #222;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .title-main {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .title-sub {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
        }

        .address-text {
            font-size: 9px;
            color: #444;
            margin: 0;
        }

        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0 10px 0;
            text-decoration: underline;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th, .data-table td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f0f4f8;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .signature-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .signature-table td {
            vertical-align: top;
        }

        .badge-step {
            font-weight: bold;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <!-- Header Kop Surat Diskominfo Medan -->
    <table class="header-table">
        <tr>
            <td width="15%" class="text-center">
                <!-- Logo Pemko Medan / Symbol -->
                <div style="font-size: 28px; font-weight: bold; color: #0d2847;">PEMKO</div>
            </td>
            <td width="85%" class="text-center">
                <div class="title-main">PEMERINTAH KOTA MEDAN</div>
                <div class="title-sub">DINAS KOMUNIKASI DAN INFORMATIKA</div>
                <div class="address-text">Jl. Kapten Maulana Lubis No. 2 Medan, Sumatera Utara - Kode Pos: 20112</div>
                <div class="address-text">Website: diskominfo.medanku.sub.id | Email: diskominfo@medan.go.id</div>
            </td>
        </tr>
    </table>

    <div class="doc-title">LAPORAN MONITORING PROGRES KEGIATAN OPERASIONAL</div>
    <div class="text-center" style="font-size: 10px; color: #555; margin-bottom: 15px;">
        Tanggal Cetak: {{ $today }}
    </div>

    <!-- Main Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="28%">Nama Kegiatan</th>
                <th width="16%">Pelaksana (Staff)</th>
                <th width="14%">Metode Transaksi</th>
                <th width="16%">Tahapan Progres</th>
                <th width="10%">Tenggat</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $index => $act)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $act->title }}</strong>
                        <div style="font-size: 8.5px; color: #666;">Triwulan {{ $act->triwulan }}</div>
                    </td>
                    <td>{{ $act->assignedUser->name ?? '-' }}</td>
                    <td>{{ $act->transaction_method_name }}</td>
                    <td>Step {{ $act->current_step }}: {{ $act->step_name }}</td>
                    <td class="text-center">{{ $act->deadline->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <strong>{{ strtoupper($act->status) }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada kegiatan yang dicatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Block -->
    <table class="signature-table">
        <tr>
            <td width="60%"></td>
            <td width="40%" class="text-center">
                Medan, {{ $today }}<br>
                <strong>Mengetahui,<br>Kepala Dinas Komunikasi dan Informatika<br>Kota Medan</strong>
                <br><br><br><br><br>
                <u><strong>H. Arrahmaan Pane, S.STP, MAP</strong></u><br>
                NIP. 19780512 199703 1 002
            </td>
        </tr>
    </table>

</body>
</html>
