@extends('layouts.app')

@section('title', 'Laporan Keuangan - SIPATU')
@section('header_title', 'Laporan Keuangan')
@section('header_subtitle', 'Laporan pembayaran dan statistik keuangan')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pembayaranPending ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Diterima -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Pembayaran Diterima</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $pembayaranDiterima ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Pembayaran Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $pembayaranDitolak ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Pembayaran Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-6 text-sm font-semibold text-gray-600">Mahasiswa</th>
                        <th class="text-left py-3 px-6 text-sm font-semibold text-gray-600">Jenis</th>
                        <th class="text-left py-3 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                        <th class="text-left py-3 px-6 text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPayments ?? [] as $payment)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-6 font-medium text-gray-800">{{ optional($payment->tagihan->mahasiswa)->nama ?? 'Unknown' }}</td>
                            <td class="py-3 px-6 text-gray-600">{{ optional($payment->tagihan)->jenis ?? '-' }}</td>
                            <td class="py-3 px-6 font-semibold text-gray-800">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="py-3 px-6">
                                @if($payment->status_verifikasi === 'diterima')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Diterima</span>
                                @elseif($payment->status_verifikasi === 'ditolak')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500">
                                Tidak ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
