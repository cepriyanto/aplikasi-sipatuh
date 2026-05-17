@extends('layouts.app')

@section('title', 'Riwayat Pembayaran - SIPATU')
@section('header_title', 'Riwayat Pembayaran')
@section('header_subtitle', 'Histori semua pembayaran mahasiswa')

@section('content')
<div class="space-y-6">
    @if(session('info'))
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-blue-800">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Riwayat</h3>
            <p class="text-sm text-gray-500">Lihat riwayat pembayaran dan unduh bukti transaksi.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard.mahasiswa.riwayat.export') }}" class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition-colors">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Transaksi</p>
            <p class="mt-3 text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Pembayaran</p>
            <p class="mt-3 text-3xl font-bold text-green-600">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Tahun Ini</p>
            <p class="mt-3 text-3xl font-bold text-blue-600">Rp {{ number_format($totalTahun, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Bulan Ini</p>
            <p class="mt-3 text-3xl font-bold text-purple-600">Rp {{ number_format($totalBulan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nominal</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Metode</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                        @php
                            $pembayaran = $transaksi->pembayaran;
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-600">{{ $loop->iteration + (method_exists($transaksis, 'currentPage') ? ($transaksis->currentPage() - 1) * $transaksis->perPage() : 0) }}</td>
                            <td class="py-4 px-6 text-gray-600">
                                <p class="font-medium text-gray-800">{{ optional($pembayaran->tanggal_bayar)->format('d F Y') ?? '-' }}</p>
                                <p class="text-sm text-gray-500">{{ optional($pembayaran->tanggal_bayar)->format('H:i:s') ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ optional($pembayaran->tagihan)->jenis ?? 'Tagihan' }}</p>
                                        <p class="text-sm text-gray-500">{{ optional($pembayaran->tagihan)->semester ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-800">Rp {{ number_format(optional($pembayaran)->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ str_replace('_', ' ', optional($pembayaran)->metode ?? '-') }}</td>
                            <td class="py-4 px-6">
                                @php
                                    $status = optional($pembayaran)->status_verifikasi ?? 'pending';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $status === 'diterima' ? 'bg-green-100 text-green-800' : ($status === 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if(optional($pembayaran)->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">Tidak ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 items-center justify-between border-t border-gray-100 px-6 py-4 md:flex-row">
            <p class="text-sm text-gray-500">Menampilkan {{ $transaksis->count() }} dari {{ method_exists($transaksis, 'total') ? $transaksis->total() : $transaksis->count() }} transaksi</p>
            @if(method_exists($transaksis, 'links'))
                {{ $transaksis->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
