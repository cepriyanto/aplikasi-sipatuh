<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; margin: 0; padding: 24px; }
        h1 { font-size: 24px; margin-bottom: 4px; }
        p { margin: 0; color: #555; }
        .header { margin-bottom: 24px; }
        .summary { margin-top: 16px; margin-bottom: 24px; }
        .summary strong { display: block; font-size: 14px; margin-bottom: 4px; }
        .summary .amount { font-size: 20px; color: #1f7a1f; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 10px 12px; font-size: 12px; }
        th { background: #f4f4f4; text-align: left; }
        tbody tr:nth-child(odd) { background: #fbfbfb; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Data berdasarkan filter yang dipilih.</p>
        @if(!empty($filters['tanggal_awal']) || !empty($filters['tanggal_akhir']) || !empty($filters['status']))
            <p style="margin-top: 8px; font-size: 12px; color: #333;">
                @if(!empty($filters['tanggal_awal'])) Tanggal Awal: {{ $filters['tanggal_awal'] }} @endif
                @if(!empty($filters['tanggal_akhir'])) &bull; Tanggal Akhir: {{ $filters['tanggal_akhir'] }} @endif
                @if(!empty($filters['status'])) &bull; Status: {{ ucfirst($filters['status']) }} @endif
            </p>
        @endif
    </div>

    <div class="summary">
        <strong>Total Pemasukan</strong>
        <div class="amount">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Mahasiswa</th>
                <th>Jenis Tagihan</th>
                <th>Nominal</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $pembayaran)
                <tr>
                    <td>{{ optional($pembayaran->tanggal_bayar)->format('d-m-Y H:i:s') ?? '-' }}</td>
                    <td>{{ optional($pembayaran->tagihan->mahasiswa)->nama ?? '-' }}</td>
                    <td>{{ optional($pembayaran->tagihan)->jenis ? ucfirst(str_replace('_', ' ', $pembayaran->tagihan->jenis)) : '-' }}</td>
                    <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ $pembayaran->metode ? ucfirst(str_replace('_', ' ', $pembayaran->metode)) : '-' }}</td>
                    <td>{{ ucfirst($pembayaran->status_verifikasi) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding: 16px; color: #777;">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
