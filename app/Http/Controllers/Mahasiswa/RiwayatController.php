<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('dashboard.mahasiswa.riwayat', [
                'transaksis' => collect(),
                'totalTransaksi' => 0,
                'totalPembayaran' => 0,
                'totalTahun' => 0,
                'totalBulan' => 0,
            ]);
        }

        $query = $mahasiswa->riwayatTransaksis()->with(['pembayaran.tagihan']);

        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $totalTransaksi = $mahasiswa->riwayatTransaksis()->count();
        $totalPembayaran = $mahasiswa->riwayatTransaksis->sum(function ($item) {
            return optional($item->pembayaran)->jumlah_bayar ?: 0;
        });
        $totalTahun = $mahasiswa->riwayatTransaksis->where('created_at', '>=', now()->startOfYear())->sum(function ($item) {
            return optional($item->pembayaran)->jumlah_bayar ?: 0;
        });
        $totalBulan = $mahasiswa->riwayatTransaksis->where('created_at', '>=', now()->startOfMonth())->sum(function ($item) {
            return optional($item->pembayaran)->jumlah_bayar ?: 0;
        });

        return view('dashboard.mahasiswa.riwayat', compact(
            'transaksis',
            'totalTransaksi',
            'totalPembayaran',
            'totalTahun',
            'totalBulan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('dashboard.mahasiswa.riwayat')
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $riwayats = $mahasiswa->riwayatTransaksis()
            ->with(['pembayaran.tagihan'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'namaMahasiswa' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'riwayats' => $riwayats,
        ];

        $pdf = Pdf::loadView('mahasiswa.pdf.riwayat', $data);

        return $pdf->download('riwayat-pembayaran.pdf');
    }
}
