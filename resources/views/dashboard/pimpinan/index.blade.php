@extends('layouts.app')

@section('title', 'Dashboard Pimpinan - SIPATU')

@section('header_title', 'Dashboard Pimpinan')
@section('header_subtitle', 'Monitoring dan laporan keuangan')

@section('content')
<div>
    <!-- Welcome Section -->
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Pimpinan</h1>
        <p class="text-gray-600">Monitoring pembayaran dan laporan keuangan</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Total Tagihan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalMahasiswa }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Persentase Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Persentase</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $persentasePembayaran }}%</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percent text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <a href="{{ route('dashboard.pimpinan.laporan') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Laporan</h3>
                    <p class="text-sm text-gray-500">Laporan keuangan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.pimpinan.rekap-tagihan') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Rekap Tagihan</h3>
                    <p class="text-sm text-gray-500">Semua tagihan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.pimpinan.monitoring') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Monitoring</h3>
                    <p class="text-sm text-gray-500">Status pembayaran</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.pimpinan.export-excel') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-excel text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Export</h3>
                    <p class="text-sm text-gray-500">Download laporan</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Tagihan by Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Status Tagihan</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ $tagihanByStatus['lunas'] }}</p>
                    <p class="text-sm text-gray-600">Lunas</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-3xl font-bold text-yellow-600">{{ $tagihanByStatus['cicilan'] }}</p>
                    <p class="text-sm text-gray-600">Cicilan</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-3xl font-bold text-red-600">{{ $tagihanByStatus['belum_lunas'] }}</p>
                    <p class="text-sm text-gray-600">Belum Lunas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h2>
        </div>
        <div class="p-6">
            @if($recentTransactions->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada transaksi</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Mahasiswa</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tagihan</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Jumlah</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaksi)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-4">
                                    <p class="font-medium text-gray-800">{{ $transaksi->tagihan->mahasiswa->nama ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaksi->tagihan->mahasiswa->nim ?? '-' }}</p>
                                </td>
                                <td class="py-3 px-4 text-gray-800">{{ $transaksi->tagihan->jenis }}</td>
                                <td class="py-3 px-4 font-medium text-gray-800">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $transaksi->tanggal_bayar->format('d F Y') }}</td>
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