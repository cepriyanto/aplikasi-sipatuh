@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - SIPATU')
@section('header_title', 'Verifikasi Pembayaran')
@section('header_subtitle', 'Periksa dan verifikasi pembayaran mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Detail Pembayaran</h3>
                
                <div class="space-y-4">
                    <!-- Mahasiswa Info -->
                    <div class="pb-4 border-b border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Mahasiswa</p>
                        <p class="text-lg font-semibold text-gray-800">{{ optional($pembayaran->tagihan->mahasiswa)->nama ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-600">NIM: {{ optional($pembayaran->tagihan->mahasiswa)->nim ?? '-' }}</p>
                    </div>

                    <!-- Tagihan Info -->
                    <div class="pb-4 border-b border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Jenis Tagihan</p>
                        <p class="text-lg font-semibold text-gray-800">{{ optional($pembayaran->tagihan)->jenis ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Semester: {{ optional($pembayaran->tagihan)->semester ?? '-' }}</p>
                    </div>

                    <!-- Jumlah -->
                    <div class="pb-4 border-b border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Jumlah Pembayaran</p>
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    </div>

                    <!-- Tanggal Bayar -->
                    <div class="pb-4 border-b border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Tanggal Pembayaran</p>
                        <p class="text-lg font-medium text-gray-800">{{ optional($pembayaran->tanggal_bayar)->format('d F Y H:i:s') ?? '-' }}</p>
                    </div>

                    <!-- Metode -->
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Metode Pembayaran</p>
                        <p class="text-lg font-medium text-gray-800">{{ str_replace('_', ' ', $pembayaran->metode ?? '-') }}</p>
                    </div>
                </div>
            </div>

            <!-- Verification Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Verifikasi Pembayaran</h3>
                
                <form method="POST" action="{{ route('dashboard.admin.keuangan.verify.process', $pembayaran->id) }}">
                    @csrf

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                    <input type="radio" name="status_verifikasi" value="diterima" class="w-4 h-4 text-green-600" required>
                                    <div>
                                        <p class="font-medium text-gray-800">Terima Pembayaran</p>
                                        <p class="text-sm text-gray-600">Pembayaran valid dan diterima</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 transition">
                                    <input type="radio" name="status_verifikasi" value="ditolak" class="w-4 h-4 text-red-600" required>
                                    <div>
                                        <p class="font-medium text-gray-800">Tolak Pembayaran</p>
                                        <p class="text-sm text-gray-600">Pembayaran tidak valid atau ada masalah</p>
                                    </div>
                                </label>
                            </div>
                            @error('status_verifikasi')
                                <p class="validation-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="4" placeholder="Masukkan keterangan jika menolak pembayaran..." class="form-control"></textarea>
                            @error('keterangan')
                                <p class="validation-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <button type="submit" class="btn btn-primary w-100 w-md-auto">
                                <i class="fas fa-check"></i> Verifikasi
                            </button>
                            <a href="{{ route('dashboard.admin.keuangan.payments') }}" class="btn btn-secondary w-100 w-md-auto mt-3 md:mt-0">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Status Info -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Saat Ini</h3>
                <div class="text-center py-6">
                    @if($pembayaran->status_verifikasi === 'diterima')
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check text-green-600 text-2xl"></i>
                        </div>
                        <p class="text-lg font-semibold text-green-600">Diterima</p>
                    @elseif($pembayaran->status_verifikasi === 'ditolak')
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                            <i class="fas fa-times text-red-600 text-2xl"></i>
                        </div>
                        <p class="text-lg font-semibold text-red-600">Ditolak</p>
                    @else
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                            <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                        </div>
                        <p class="text-lg font-semibold text-yellow-600">Pending</p>
                    @endif
                </div>
            </div>

            <!-- Verified By -->
            @if($pembayaran->status_verifikasi !== 'pending')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Diverifikasi Oleh</h3>
                    <p class="text-gray-800 font-medium">{{ optional($pembayaran->verifiedBy)->name ?? '-' }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
