<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Notifikasi;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $tagihans = $mahasiswa
            ? $mahasiswa->tagihans()->with('pembayarans')->whereIn('status', ['belum_lunas', 'cicilan'])->orderBy('tanggal_jatuh_tempo', 'asc')->get()
            : collect();

        $virtualAccount = [
            'bank' => 'BCA Virtual Account',
            'number' => '8828 1234 5678',
            'holder' => $user->name,
            'expired' => now()->addDays(3)->format('d F Y'),
        ];

        return view('dashboard.mahasiswa.pembayaran', compact('tagihans', 'virtualAccount'));
    }

    public function showPaymentForm(Tagihan $tagihan)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa || $tagihan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        $tagihan->load('pembayarans');

        $virtualAccount = [
            'bank' => 'BCA Virtual Account',
            'number' => '8828 1234 5678',
            'holder' => $user->name,
            'expired' => now()->addDays(3)->format('d F Y'),
        ];

        return view('dashboard.mahasiswa.payment', compact('tagihan', 'virtualAccount'));
    }

    public function storePayment(Request $request, Tagihan $tagihan)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa || $tagihan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1000|max:' . $tagihan->jumlah,
            'metode' => 'required|in:transfer_bank,e_wallet,cash',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $pembayaran = Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'tanggal_bayar' => now(),
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode' => $request->metode,
            'status_verifikasi' => 'pending',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $pembayaran->bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $pembayaran->save();
        }

        RiwayatTransaksi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'pembayaran_id' => $pembayaran->id,
            'keterangan' => 'Pembayaran tagihan ' . $tagihan->jenis . ' sebesar Rp ' . number_format($request->jumlah_bayar, 0, ',', '.'),
        ]);

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
