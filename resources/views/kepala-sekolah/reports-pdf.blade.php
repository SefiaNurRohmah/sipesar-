<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PPDB - SD Negeri Larangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0d9488;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 18px;
            color: #0d9488;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #0d9488;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status-diterima {
            background-color: #dcfce7;
            color: #166534;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
        }

        .status-menunggu {
            background-color: #fef3c7;
            color: #b45309;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
        }

        .status-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .footer p {
            margin: 5px 0;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SD NEGERI LARANGAN</h1>
        <p>Portal SIPESAR (Sistem Penerimaan Siswa Baru)</p>
        <p>Jl. Pendidikan No. 123, Larangan, Surabaya</p>
    </div>

    <div class="info">
        <h3 style="margin-bottom: 10px;">LAPORAN DATA PENDAFTAR PPDB</h3>
        <p><strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i') }} WIB</p>
        <p><strong>Total Data:</strong> {{ count($registrations) }} pendaftar</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Lengkap</th>
                <th style="width: 18%;">NIK</th>
                <th style="width: 25%;">Asal TK</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 15%;">Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $registration)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->nama }}</td>
                    <td>{{ $registration->nik }}</td>
                    <td>{{ $registration->nama_tk ?? '-' }}</td>
                    <td>
                        @if ($registration->status == 'diterima')
                            <span class="status-diterima">Diterima</span>
                        @elseif($registration->status == 'tidak diterima')
                            <span class="status-ditolak">Ditolak</span>
                        @else
                            <span class="status-menunggu">Menunggu</span>
                        @endif
                    </td>
                    <td>{{ $registration->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        Tidak ada data pendaftar
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Surabaya, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px;"><strong>Kepala Sekolah</strong></p>
        <p>SD Negeri Larangan</p>
    </div>
</body>

</html>
