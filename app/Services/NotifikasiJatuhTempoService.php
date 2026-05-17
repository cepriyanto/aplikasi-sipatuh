<?php

namespace App\Services;

use App\Models\Tagihan;
use App\Models\Notifikasi;
use Carbon\Carbon;

class NotifikasiJatuhTempoService
{
    /**
     * Jalankan notifikasi jatuh tempo untuk semua tagihan belum lunas
     */
    public function kirimNotifikasiJatuhTempo()
    {
        // Ambil semua tagihan dengan status belum_lunas
        $tagihans = Tagihan::where('status', Tagihan::STATUS_BELUM_LUNAS)->get();

        foreach ($tagihans as $tagihan) {
            $this->cekDanBuatNotifikasi($tagihan);
        }
    }

    /**
     * Kirim pengingat manual untuk tagihan tertentu
     */
    public function kirimPengingatManual(Tagihan $tagihan)
    {
        return $this->cekDanBuatNotifikasi($tagihan, true);
    }

    /**
     * Cek dan buat notifikasi untuk tagihan tertentu
     */
    public function cekDanBuatNotifikasi(Tagihan $tagihan, $force = false)
    {
        $hariIni = Carbon::today()->startOfDay();
        $jatuhTempo = Carbon::parse($tagihan->tanggal_jatuh_tempo)->startOfDay();
        $selisihHari = $hariIni->diffInDays($jatuhTempo, false); // false untuk mendapatkan nilai negatif jika lewat

        $notifikasiData = null;

        if ($selisihHari === 3) {
            $notifikasiData = [
                'judul' => 'Pemberitahuan Jatuh Tempo',
                'pesan' => "Tagihan {$tagihan->jenis} akan jatuh tempo dalam 3 hari",
                'type' => Notifikasi::TYPE_WARNING,
            ];
        } elseif ($selisihHari === 1) {
            $notifikasiData = [
                'judul' => 'Pemberitahuan Jatuh Tempo',
                'pesan' => "Tagihan {$tagihan->jenis} akan jatuh tempo besok",
                'type' => Notifikasi::TYPE_WARNING,
            ];
        } elseif ($selisihHari === 0) {
            $notifikasiData = [
                'judul' => 'Pemberitahuan Jatuh Tempo',
                'pesan' => "Hari ini adalah batas pembayaran {$tagihan->jenis}",
                'type' => Notifikasi::TYPE_DANGER,
            ];
        } elseif ($selisihHari < 0) {
            $notifikasiData = [
                'judul' => 'Pemberitahuan Jatuh Tempo',
                'pesan' => "Tagihan {$tagihan->jenis} telah melewati jatuh tempo",
                'type' => Notifikasi::TYPE_DANGER,
            ];
        } else {
            // Jika dipaksa (manual) tapi tidak masuk kriteria tanggal, buat pesan umum
            if ($force) {
                $notifikasiData = [
                    'judul' => 'Pengingat Pembayaran',
                    'pesan' => "Mengingatkan untuk pembayaran tagihan {$tagihan->jenis} sebesar Rp " . number_format($tagihan->jumlah, 0, ',', '.') . " yang jatuh tempo pada " . $tagihan->tanggal_jatuh_tempo->format('d M Y'),
                    'type' => Notifikasi::TYPE_WARNING,
                ];
            }
        }

        if ($notifikasiData) {
            if (!$tagihan->mahasiswa || !$tagihan->mahasiswa->user_id) {
                return false;
            }

            // Cek apakah notifikasi sudah dibuat untuk tagihan ini dengan pesan yang sama
            $sudahAda = Notifikasi::where('tagihan_id', $tagihan->id)
                ->where('pesan', $notifikasiData['pesan'])
                ->exists();

            if ($force || !$sudahAda) {
                Notifikasi::create([
                    'user_id' => $tagihan->mahasiswa->user_id,
                    'tagihan_id' => $tagihan->id,
                    'judul' => $notifikasiData['judul'],
                    'pesan' => $notifikasiData['pesan'],
                    'status' => Notifikasi::STATUS_BELUM,
                    'type' => $notifikasiData['type'],
                ]);
                return true;
            }
        }
        return false;
    }
}