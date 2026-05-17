<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Pembayaran::with(['tagihan.mahasiswa', 'tagihan']);

        if (!empty($this->filters['tanggal_awal'])) {
            $query->whereDate('tanggal_bayar', '>=', $this->filters['tanggal_awal']);
        }

        if (!empty($this->filters['tanggal_akhir'])) {
            $query->whereDate('tanggal_bayar', '<=', $this->filters['tanggal_akhir']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status_verifikasi', $this->filters['status']);
        }

        return $query->orderBy('tanggal_bayar', 'desc')->get()->map(function (Pembayaran $pembayaran) {
            return [
                'Tanggal' => optional($pembayaran->tanggal_bayar)->format('d-m-Y H:i:s') ?: '-',
                'Nama' => optional($pembayaran->tagihan->mahasiswa)->nama ?: '-',
                'Jenis Tagihan' => optional($pembayaran->tagihan)->jenis ? ucfirst(str_replace('_', ' ', $pembayaran->tagihan->jenis)) : '-',
                'Nominal' => $pembayaran->jumlah_bayar,
                'Metode' => $pembayaran->metode ? ucfirst(str_replace('_', ' ', $pembayaran->metode)) : '-',
                'Status' => $pembayaran->status_verifikasi ? ucfirst($pembayaran->status_verifikasi) : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'Jenis Tagihan',
            'Nominal',
            'Metode',
            'Status',
        ];
    }
}
