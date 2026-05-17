<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; margin: 0; padding: 0; }
        .page { padding: 24px; }
        h1, h2 { margin: 0 0 12px 0; }
        .header { margin-bottom: 24px; }
        .subtitle { color: #555; margin-top: 4px; }
        .student-info { margin-bottom: 20px; }
        .student-info span { display: inline-block; margin-right: 18px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding: 10px 12px; border: 1px solid #ddd; font-size: 12px; }
        th { background: #f4f4f4; text-align: left; }
        tbody tr:nth-child(odd) { background: #fbfbfb; }
        .text-right { text-align: right; }
        .status { padding: 4px 8px; border-radius: 4px; display: inline-block; font-size: 11px; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.diterima { background: #dcfce7; color: #166534; }
        .status.ditolak { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <h1>Riwayat Pembayaran Mahasiswa</h1>
        <p class="subtitle">Daftar riwayat pembayaran mahasiswa berdasarkan pengguna yang login.</p>
    </div>

    <div class="student-info">
        <span><strong>Nama:</strong> {{ $namaMahasiswa }}</span>
        <span><strong>NIM:</strong> {{ $nim }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Tagihan</th>
                <th>Nominal</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $index => $riwayat)
                @php
                    $pembayaran = $riwayat->pembayaran;
                    $tagihan = optional($pembayaran)->tagihan;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($pembayaran->tanggal_bayar)->format('d F Y') ?? '-' }}</td>
                    <td>{{ optional($tagihan)->jenis ? ucfirst(str_replace('_', ' ', $tagihan->jenis)) : '-' }}</td>
                    <td class="text-right">Rp {{ number_format(optional($pembayaran)->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                    <td>{{ optional($pembayaran)->metode ? ucfirst(str_replace('_', ' ', optional($pembayaran)->metode)) : '-' }}</td>
                    <td>
                        @php
                            $status = optional($pembayaran)->status_verifikasi ?? 'pending';
                        @endphp
                        <span class="status {{ $status }}">{{ ucfirst($status) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-right">Tidak ada riwayat pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
