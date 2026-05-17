<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Exports\LaporanExport;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display pimpinan dashboard
     */
    public function index()
    {
        // Get total statistics
        $totalTagihan = Tagihan::sum('jumlah');
        $totalPembayaran = Pembayaran::where('status_verifikasi', 'diterima')->sum('jumlah_bayar');
        $totalMahasiswa = Mahasiswa::count();

        // Calculate payment percentage
        $persentasePembayaran = $totalTagihan > 0 
            ? round(($totalPembayaran / $totalTagihan) * 100, 2) 
            : 0;

        // Get tagihan by status
        $tagihanByStatus = [
            'lunas' => Tagihan::where('status', 'lunas')->count(),
            'cicilan' => Tagihan::where('status', 'cicilan')->count(),
            'belum_lunas' => Tagihan::where('status', 'belum_lunas')->count(),
        ];

        // Get monthly payment data (last 12 months)
        $monthlyPayments = Pembayaran::select(
            DB::raw('MONTH(tanggal_bayar) as bulan'),
            DB::raw('YEAR(tanggal_bayar) as tahun'),
            DB::raw('SUM(jumlah_bayar) as total')
        )
            ->where('status_verifikasi', 'diterima')
            ->where('tanggal_bayar', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('YEAR(tanggal_bayar), MONTH(tanggal_bayar)'))
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        // Get payment by jenis tagihan
        $pembayaranByJenis = Tagihan::select('jenis', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis')
            ->get();

        // Get recent transactions
        $recentTransactions = Pembayaran::with(['tagihan.mahasiswa', 'tagihan'])
            ->where('status_verifikasi', 'diterima')
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.pimpinan.index', compact(
            'totalTagihan',
            'totalPembayaran',
            'totalMahasiswa',
            'persentasePembayaran',
            'tagihanByStatus',
            'monthlyPayments',
            'pembayaranByJenis',
            'recentTransactions'
        ));
    }

    /**
     * Display laporan keuangan
     */
    public function laporan(Request $request)
    {
        $query = Pembayaran::with(['tagihan.mahasiswa', 'tagihan']);

        // Filter by date range
        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_awal);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_akhir);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_verifikasi', $request->status);
        }

        $pembayarans = $query->orderBy('tanggal_bayar', 'desc')->get();

        // Calculate totals
        $totalPemasukan = $pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar');
        $totalPending = $pembayarans->where('status_verifikasi', 'pending')->sum('jumlah_bayar');
        $totalDitolak = $pembayarans->where('status_verifikasi', 'ditolak')->sum('jumlah_bayar');

        // Summary by semester
        $bySemester = $pembayarans->groupBy(function ($item) {
            return $item->tagihan->semester ?? 'Unknown';
        })->map(function ($items) {
            return [
                'total' => $items->sum('jumlah_bayar'),
                'count' => $items->count(),
            ];
        });

        return view('dashboard.pimpinan.laporan', compact(
            'pembayarans',
            'totalPemasukan',
            'totalPending',
            'totalDitolak',
            'bySemester'
        ));
    }

    /**
     * Display rekap tagihan
     */
    public function rekapTagihan(Request $request)
    {
        $query = Tagihan::with('mahasiswa');

        // Filter by semester
        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        // Filter by jenis
        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tagihans = $query->orderBy('created_at', 'desc')->get();

        // Summary
        $summary = [
            'total' => $tagihans->sum('jumlah'),
            'lunas' => $tagihans->where('status', 'lunas')->sum('jumlah'),
            'cicilan' => $tagihans->where('status', 'cicilan')->sum('jumlah'),
            'belum_lunas' => $tagihans->where('status', 'belum_lunas')->sum('jumlah'),
        ];

        // Get available semesters
        $semesters = Tagihan::distinct()->pluck('semester');

        return view('dashboard.pimpinan.rekap-tagihan', compact(
            'tagihans',
            'summary',
            'semesters'
        ));
    }

    /**
     * Build laporan query with optional filters.
     */
    private function buildLaporanQuery(Request $request)
    {
        $query = Pembayaran::with(['tagihan.mahasiswa', 'tagihan']);

        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_awal);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_akhir);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status_verifikasi', $request->status);
        }

        return $query;
    }

    /**
     * Display monitoring pembayaran
     */
    public function monitoring(Request $request)
    {
        $query = Mahasiswa::with(['tagihans', 'tagihans.pembayarans']);

        // Filter byjurusan
        if ($request->has('jurusan') && $request->jurusan) {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter by angkatan
        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        $mahasiswas = $query->get()->map(function ($mhs) {
            $totalTagihan = $mhs->tagihans->sum('jumlah');
            $totalBayar = $mhs->tagihans->flatMap->pembayarans
                ->where('status_verifikasi', 'diterima')
                ->sum('jumlah_bayar');
            
            $mhs->total_tagihan = $totalTagihan;
            $mhs->total_bayar = $totalBayar;
            $mhs->persentase = $totalTagihan > 0 ? round(($totalBayar / $totalTagihan) * 100, 2) : 0;
            
            return $mhs;
        });

        // Get unique filters
        $jurusans = Mahasiswa::distinct()->pluck('jurusan');
        $angkatans = Mahasiswa::distinct()->pluck('angkatan')->sort()->reverse();

        return view('dashboard.pimpinan.monitoring', compact(
            'mahasiswas',
            'jurusans',
            'angkatans'
        ));
    }

    /**
     * Export laporan to PDF
     */
    public function exportPdf(Request $request)
    {
        $pembayarans = $this->buildLaporanQuery($request)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalPemasukan = $pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar');

        $pdf = Pdf::loadView('pimpinan.pdf.laporan', [
            'pembayarans' => $pembayarans,
            'totalPemasukan' => $totalPemasukan,
            'filters' => $request->only(['tanggal_awal', 'tanggal_akhir', 'status']),
        ]);

        return $pdf->download('laporan-keuangan.pdf');
    }

    /**
     * Export laporan to Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request->only(['tanggal_awal', 'tanggal_akhir', 'status'])), 'laporan-keuangan.xlsx');
    }
}
