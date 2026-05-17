<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display mahasiswa dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('dashboard.mahasiswa.index', [
                'user' => $user,
                'tagihans' => collect(),
                'totalTagihan' => 0,
                'totalBayar' => 0,
                'sisaTagihan' => 0,
                'notifikasis' => collect(),
            ]);
        }

        // Get tagihan mahasiswa
        $tagihans = $mahasiswa->tagihans()->with('pembayarans')->get();

        // Calculate totals
        $totalTagihan = $tagihans->sum('jumlah');
        $totalBayar = $tagihans->sum(function ($tagihan) {
            return $tagihan->pembayarans()
                ->where('status_verifikasi', 'diterima')
                ->sum('jumlah_bayar');
        });
        $sisaTagihan = $totalTagihan - $totalBayar;

        // Get notifikasi
        $notifikasis = $user->notifikasis()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.mahasiswa.index', compact(
            'user',
            'tagihans',
            'totalTagihan',
            'totalBayar',
            'sisaTagihan',
            'notifikasis'
        ));
    }

    /**
     * Display tagihan list
     */
    public function tagihan()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('dashboard.mahasiswa.tagihan', [
                'tagihans' => collect(),
            ]);
        }

        $tagihans = $mahasiswa->tagihans()
            ->with('pembayarans')
            ->orderBy('tanggal_jatuh_tempo', 'desc')
            ->get();

        return view('dashboard.mahasiswa.tagihan', compact('tagihans'));
    }

    /**
     * Display riwayat transaksi
     */
    public function riwayat()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('dashboard.mahasiswa.riwayat', [
                'transaksis' => collect(),
            ]);
        }

        $transaksis = $mahasiswa->riwayatTransaksis()
            ->with('pembayaran')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.mahasiswa.riwayat', compact('transaksis'));
    }

    /**
     * Display pembayaran page
     */
    public function pembayaran()
    {
        return view('dashboard.pembayaran');
    }

    /**
     * Display notifikasi page
     */
    public function notifikasi()
    {
        return view('dashboard.notifikasi');
    }

    /**
     * Show payment form
     */
    public function showPaymentForm(Tagihan $tagihan)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Verify ownership
        if (!$mahasiswa || $tagihan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.mahasiswa.payment', compact('tagihan'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, Tagihan $tagihan)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Verify ownership
        if (!$mahasiswa || $tagihan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1000',
            'metode' => 'required|in:transfer_bank,e_wallet,cash',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $pembayaran = new Pembayaran();
        $pembayaran->tagihan_id = $tagihan->id;
        $pembayaran->tanggal_bayar = now();
        $pembayaran->jumlah_bayar = $request->jumlah_bayar;
        $pembayaran->metode = $request->metode;
        $pembayaran->status_verifikasi = 'pending';

        // Handle file upload
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $path = $file->store('bukti_pembayaran', 'public');
            $pembayaran->bukti_pembayaran = $path;
        }

        $pembayaran->save();

        // Create riwayat transaksi
        \App\Models\RiwayatTransaksi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'pembayaran_id' => $pembayaran->id,
            'keterangan' => 'Pembayaran tagihan ' . $tagihan->jenis . ' sebesar Rp ' . number_format($request->jumlah_bayar, 0, ',', '.'),
        ]);

        // Create notifikasi
        Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'Pembayaran Dikirim',
            'pesan' => 'Pembayaran sebesar Rp ' . number_format($request->jumlah_bayar, 0, ',', '.') . ' untuk tagihan ' . $tagihan->jenis . ' telah dikirim dan menunggu verifikasi.',
            'status' => 'belum',
        ]);

        return redirect()->route('dashboard.mahasiswa.tagihan')
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}