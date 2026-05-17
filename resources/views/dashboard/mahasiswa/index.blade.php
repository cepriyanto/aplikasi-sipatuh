@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - SIPATU')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Kelola tagihan dan pembayaran Anda')

@section('content')
<div>
    <!-- Welcome Section -->
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h1>
        <p class="text-gray-600">Berikut ringkasan tagihan dan pembayaran Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Tagihan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Bayar -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Dibayar</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-600">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Sisa Tagihan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Sisa Tagihan</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-600">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Tagihan</h2>
        </div>
        
        <div class="p-6">
            @if($tagihans->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada tagihan</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($tagihans as $tagihan)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($tagihan->status == 'lunas') bg-green-100 text-green-800
                                        @elseif($tagihan->status == 'cicilan') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($tagihan->status) }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $tagihan->jenis }}</span>
                                </div>
                                <h3 class="font-semibold text-gray-800">{{ $tagihan->jenis }} - {{ $tagihan->semester }}</h3>
                                <p class="text-sm text-gray-500">Jatuh tempo: {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d F Y') }}</p>
                            </div>
                            <div class="sm:text-right">
                                <p class="text-base sm:text-lg font-bold text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Dibayar: Rp {{ number_format($tagihan->pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar'), 0, ',', '.') }}</p>
                                @if($tagihan->status != 'lunas')
                                <a href="{{ route('dashboard.mahasiswa.payment.form', $tagihan->id) }}" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                    Bayar Sekarang
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Notifikasi -->
    @if($notifikasis->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Notifikasi Terbaru</h2>
        </div>
        
        <div class="p-6">
            <div class="space-y-3">
                @foreach($notifikasis as $notifikasi)
                <div class="flex items-start gap-3 p-3 rounded-lg {{ $notifikasi->status == 'belum' ? 'bg-blue-50' : 'bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                        @if($notifikasi->status == 'belum') bg-blue-100 @else bg-gray-200 @endif">
                        <i class="fas fa-bell text-sm {{ $notifikasi->status == 'belum' ? 'text-blue-600' : 'text-gray-500' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $notifikasi->judul }}</p>
                        <p class="text-sm text-gray-600">{{ $notifikasi->pesan }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notifikasi->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection