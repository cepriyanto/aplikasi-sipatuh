@extends('layouts.app')

@section('title', 'Dashboard Admin Keuangan - SIPATU')

@section('header_title', 'Dashboard Admin Keuangan')
@section('header_subtitle', 'Kelola dan verifikasi pembayaran mahasiswa')

@section('content')
<div>
    <!-- Welcome Section -->
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin Keuangan</h1>
        <p class="text-gray-600">Kelola dan verifikasi pembayaran mahasiswa</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Verifikasi</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pembayaranPending }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Diterima -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Diterima</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $pembayaranDiterima }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $pembayaranDitolak }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <a href="{{ route('dashboard.admin.keuangan.payments') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Semua Pembayaran</h3>
                    <p class="text-sm text-gray-500">Lihat & verifikasi pembayaran</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.admin.keuangan.tagihans') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Kelola Tagihan</h3>
                    <p class="text-sm text-gray-500">Tambah & edit tagihan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.admin.keuangan.laporan') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Laporan</h3>
                    <p class="text-sm text-gray-500">Generate laporan keuangan</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Tagihan Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Ringkasan Tagihan</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-800">{{ $tagihanSummary['total'] }}</p>
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $tagihanSummary['lunas'] }}</p>
                    <p class="text-sm text-gray-500">Lunas</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $tagihanSummary['cicilan'] }}</p>
                    <p class="text-sm text-gray-500">Cicilan</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-red-600">{{ $tagihanSummary['belum_lunas'] }}</p>
                    <p class="text-sm text-gray-500">Belum Lunas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Pembayaran Terbaru</h2>
            <a href="{{ route('dashboard.admin.keuangan.payments') }}" class="text-blue-600 hover:text-blue-700 text-sm">Lihat Semua</a>
        </div>
        
        <div class="p-6">
            @if($recentPayments->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada pembayaran</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px]">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Mahasiswa</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tagihan</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Jumlah</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $pembayaran)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <p class="font-medium text-gray-800">{{ $pembayaran->tagihan->mahasiswa->nama ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">{{ $pembayaran->tagihan->mahasiswa->nim ?? '-' }}</p>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="text-gray-800">{{ $pembayaran->tagihan->jenis }}</p>
                                    <p class="text-sm text-gray-500">{{ $pembayaran->tagihan->semester }}</p>
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-800">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($pembayaran->status_verifikasi == 'diterima') bg-green-100 text-green-800
                                        @elseif($pembayaran->status_verifikasi == 'ditolak') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($pembayaran->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-600">{{ $pembayaran->tanggal_bayar->format('d F Y') }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('dashboard.admin.keuangan.verify', $pembayaran->id) }}" class="text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection