<?php

namespace App\Http\Controllers\AdminKeuangan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\LogAktivitas;
use App\Services\NotifikasiJatuhTempoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin keuangan dashboard
     */
    public function index()
    {
        // Get statistics
        $totalPemasukan = Pembayaran::where('status_verifikasi', 'diterima')
            ->sum('jumlah_bayar');

        $pembayaranPending = Pembayaran::where('status_verifikasi', 'pending')
            ->count();

        $pembayaranDiterima = Pembayaran::where('status_verifikasi', 'diterima')
            ->count();

        $pembayaranDitolak = Pembayaran::where('status_verifikasi', 'ditolak')
            ->count();

        // Get recent payments
        $recentPayments = Pembayaran::with(['tagihan.mahasiswa', 'tagihan'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get tagihan summary
        $tagihanSummary = [
            'total' => Tagihan::count(),
            'lunas' => Tagihan::where('status', 'lunas')->count(),
            'cicilan' => Tagihan::where('status', 'cicilan')->count(),
            'belum_lunas' => Tagihan::where('status', 'belum_lunas')->count(),
        ];

        return view('dashboard.admin.keuangan.index', compact(
            'totalPemasukan',
            'pembayaranPending',
            'pembayaranDiterima',
            'pembayaranDitolak',
            'recentPayments',
            'tagihanSummary'
        ));
    }

    /**
     * Display all payments
     */
    public function payments(Request $request)
    {
        $query = Pembayaran::with(['tagihan.mahasiswa', 'tagihan', 'verifiedBy']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter by date range
        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_awal);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_akhir);
        }

        // Filter by mahasiswa
        if ($request->has('mahasiswa_id') && $request->mahasiswa_id) {
            $query->whereHas('tagihan', function ($q) use ($request) {
                $q->where('mahasiswa_id', $request->mahasiswa_id);
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.keuangan.payments', compact('payments'));
    }

    /**
     * Display payment verification page
     */
    public function verify(Pembayaran $pembayaran)
    {
        $pembayaran->load(['tagihan.mahasiswa', 'tagihan']);

        return view('dashboard.admin.keuangan.verify', compact('pembayaran'));
    }

    /**
     * Process payment verification
     */
    public function processVerification(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:diterima,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $pembayaran, $user) {
            $oldStatus = $pembayaran->status_verifikasi;
            $pembayaran->status_verifikasi = $request->status_verifikasi;
            $pembayaran->verified_by = $user->id;
            $pembayaran->save();

            // Update tagihan status if diterima
            if ($request->status_verifikasi === 'diterima') {
                $tagihan = $pembayaran->tagihan;
                $totalBayar = $tagihan->pembayarans()
                    ->where('status_verifikasi', 'diterima')
                    ->sum('jumlah_bayar');

                if ($totalBayar >= $tagihan->jumlah) {
                    $tagihan->status = 'lunas';
                } elseif ($totalBayar > 0) {
                    $tagihan->status = 'cicilan';
                }
                $tagihan->save();
            }

            // Create notifikasi for mahasiswa
            $tagihan = $pembayaran->tagihan;
            $notifikasi = Notifikasi::create([
                'user_id' => $tagihan->mahasiswa->user_id,
                'judul' => $request->status_verifikasi === 'diterima' 
                    ? 'Pembayaran Diterima' 
                    : 'Pembayaran Ditolak',
                'pesan' => $request->status_verifikasi === 'diterima'
                    ? 'Pembayaran sebesar Rp ' . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . ' untuk tagihan ' . $tagihan->jenis . ' telah diverifikasi dan diterima.'
                    : 'Pembayaran sebesar Rp ' . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . ' untuk tagihan ' . $tagihan->jenis . ' ditolak. ' . ($request->keterangan ?? 'Silakan upload ulang bukti pembayaran.'),
                'status' => 'belum',
            ]);

            // Log aktivitas
            LogAktivitas::create([
                'user_id' => $user->id,
                'aksi' => 'verifikasi_pembayaran',
                'deskripsi' => 'Memverifikasi pembayaran ID: ' . $pembayaran->id . ' dengan status: ' . $request->status_verifikasi,
                'tabel_terkait' => 'pembayarans',
                'record_id' => $pembayaran->id,
            ]);
        });

        $message = $request->status_verifikasi === 'diterima'
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran berhasil ditolak.';

        return redirect()->route('dashboard.admin.keuangan.payments')
            ->with('success', $message);
    }

    /**
     * Display tagihan management
     */
    public function tagihans(Request $request)
    {
        $query = Tagihan::with('mahasiswa');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by jenis
        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $tagihans = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.keuangan.tagihans', compact('tagihans'));
    }

    /**
     * Create new tagihan
     */
    public function createTagihan()
    {
        $mahasiswas = Mahasiswa::with('user')->get();
        return view('dashboard.admin.keuangan.create-tagihan', compact('mahasiswas'));
    }

    /**
     * Store new tagihan
     */
    public function storeTagihan(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'jenis' => 'required|in:UKT,SPP,DENDA,LAINNYA',
            'semester' => 'required|string|max:10',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $tagihan = Tagihan::create($request->all());
        
        // Generate due date notification for this specific tagihan
        app(NotifikasiJatuhTempoService::class)->cekDanBuatNotifikasi($tagihan);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'create_tagihan',
            'deskripsi' => 'Membuat tagihan baru ID: ' . $tagihan->id . ' untuk mahasiswa ID: ' . $request->mahasiswa_id,
            'tabel_terkait' => 'tagihans',
            'record_id' => $tagihan->id,
        ]);

        return redirect()->route('dashboard.admin.keuangan.tagihans')
            ->with('success', 'Tagihan berhasil dibuat.');
    }

    /**
     * Generate laporan
     */
    public function laporan(Request $request)
    {
        $query = Pembayaran::with(['tagihan.mahasiswa', 'tagihan']);

        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_awal);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_akhir);
        }

        $pembayarans = $query->get();
        
        $totalPemasukan = $pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar');
        $pembayaranPending = Pembayaran::where('status_verifikasi', 'pending')->count();
        $pembayaranDiterima = Pembayaran::where('status_verifikasi', 'diterima')->count();
        $pembayaranDitolak = Pembayaran::where('status_verifikasi', 'ditolak')->count();
        $recentPayments = Pembayaran::with(['tagihan.mahasiswa', 'tagihan'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin.keuangan.laporan', compact(
            'totalPemasukan',
            'pembayaranPending',
            'pembayaranDiterima',
            'pembayaranDitolak',
            'recentPayments'
        ));
    }

    /**
     * Send manual reminder for a tagihan
     */
    public function sendReminder(Tagihan $tagihan)
    {
        $sent = app(NotifikasiJatuhTempoService::class)->kirimPengingatManual($tagihan);

        if ($sent) {
            return back()->with('success', 'Notifikasi pengingat berhasil dikirim ke mahasiswa.');
        }

        return back()->with('error', 'Gagal mengirim notifikasi. Pastikan data mahasiswa valid.');
    }
}