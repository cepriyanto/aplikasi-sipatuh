<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use App\Models\RiwayatTransaksi;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SipatuSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate([
            'email' => 'mahasiswa@example.com',
        ], [
            'name' => 'Mahasiswa Demo',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $mahasiswa = Mahasiswa::updateOrCreate([
            'nim' => '2023123456',
        ], [
            'user_id' => $user->id,
            'nama' => 'Dina Putri',
            'jurusan' => 'Teknologi Informasi',
            'angkatan' => 2023,
        ]);

        $tagihan1 = Tagihan::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'jenis' => 'UKT',
            'semester' => 'Genap 2025',
        ], [
            'jumlah' => 2500000,
            'tanggal_jatuh_tempo' => now()->addDays(10)->toDateString(),
            'status' => 'belum_lunas',
        ]);

        $tagihan2 = Tagihan::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'jenis' => 'SPP',
            'semester' => 'April 2026',
        ], [
            'jumlah' => 500000,
            'tanggal_jatuh_tempo' => now()->subDays(15)->toDateString(),
            'status' => 'lunas',
        ]);

        $tagihan3 = Tagihan::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'jenis' => 'SPP',
            'semester' => 'Maret 2026',
        ], [
            'jumlah' => 500000,
            'tanggal_jatuh_tempo' => now()->subMonths(1)->toDateString(),
            'status' => 'lunas',
        ]);

        $pembayaran1 = Pembayaran::updateOrCreate([
            'tagihan_id' => $tagihan2->id,
            'jumlah_bayar' => 500000,
        ], [
            'tanggal_bayar' => now()->subDays(14),
            'metode' => 'transfer_bank',
            'status_verifikasi' => 'diterima',
        ]);

        $pembayaran2 = Pembayaran::updateOrCreate([
            'tagihan_id' => $tagihan3->id,
            'jumlah_bayar' => 500000,
        ], [
            'tanggal_bayar' => now()->subDays(35),
            'metode' => 'e_wallet',
            'status_verifikasi' => 'diterima',
        ]);

        RiwayatTransaksi::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'pembayaran_id' => $pembayaran1->id,
        ], [
            'keterangan' => 'Pembayaran SPP April 2026 berhasil diverifikasi.',
        ]);

        RiwayatTransaksi::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'pembayaran_id' => $pembayaran2->id,
        ], [
            'keterangan' => 'Pembayaran SPP Maret 2026 berhasil diverifikasi.',
        ]);

        Notifikasi::updateOrCreate([
            'user_id' => $user->id,
            'judul' => 'Pembayaran SPP April 2026 berhasil',
        ], [
            'pesan' => 'Pembayaran SPP April 2026 sebesar Rp 500.000 telah diverifikasi dan diterima.',
            'status' => 'belum',
        ]);

        Notifikasi::updateOrCreate([
            'user_id' => $user->id,
            'judul' => 'Informasi jatuh tempo UKT',
        ], [
            'pesan' => 'Tagihan UKT Genap 2025/2026 akan jatuh tempo dalam 10 hari. Segera lakukan pembayaran.',
            'status' => 'belum',
        ]);

        // Create admin keuangan user
        User::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin Keuangan',
            'password' => Hash::make('Admin123'),
            'role' => 'admin_keuangan',
        ]);

        // Create akademik user
        User::updateOrCreate([
            'email' => 'akademik@gmail.com',
        ], [
            'name' => 'Bagian Akademik',
            'password' => Hash::make('Akademik123'),
            'role' => 'akademik',
        ]);

        // Create pimpinan user
        User::updateOrCreate([
            'email' => 'pimpinan@gmail.com',
        ], [
            'name' => 'Pimpinan',
            'password' => Hash::make('Pimpinan123'),
            'role' => 'pimpinan',
        ]);
    }
}
