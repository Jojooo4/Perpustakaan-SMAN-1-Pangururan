<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Denda Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
        }
        .header h2 {
            margin: 5px 0;
            color: #7f8c8d;
            font-size: 16px;
            font-weight: normal;
        }
        .meta {
            margin-bottom: 20px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #34495e;
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
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-box {
            background-color: #ecf0f1;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid #e74c3c;
        }
        .total-box h3 {
            margin: 0;
            color: #e74c3c;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-lunas {
            background-color: #2ecc71;
            color: white;
        }
        .status-belum {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SMA N 1 PANGURURAN</h1>
        <h2>Laporan Denda Peminjaman Buku</h2>
    </div>

    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i') }} WIB<br>
        <strong>Total Transaksi:</strong> {{ $denda->count() }} peminjaman
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Peminjam</th>
                <th width="30%">Judul Buku</th>
                <th width="15%">Tgl Kembali</th>
                <th width="15%">Jatuh Tempo</th>
                <th width="15%" class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($denda as $index => $d)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $d->user->nama ?? '-' }}</td>
                <td>{{ $d->asetBuku->buku->judul ?? '-' }}</td>
                <td>{{ $d->tanggal_kembali ? $d->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                <td>{{ $d->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($d->denda, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data denda</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        <h3>Total Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
    </div>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->nama ?? 'Admin' }}</p>
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Perpustakaan Digital</p>
    </div>
</body>
</html>
