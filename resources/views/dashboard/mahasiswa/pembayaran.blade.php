@extends('layouts.app')

@section('title', 'Pembayaran - SIPATU')
@section('header_title', 'Pembayaran')
@section('header_subtitle', 'Proses pembayaran dan informasi Virtual Account')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        @if(session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Tagihan Terdekat</h3>
                    <p class="text-sm text-gray-500">Pilih tagihan yang ingin Anda bayar hari ini.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">{{ $tagihans->count() }} tagihan aktif</span>
            </div>

            @if($tagihans->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-check-circle text-4xl mb-4"></i>
                    Belum ada tagihan aktif untuk saat ini.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($tagihans as $tagihan)
                        <div class="rounded-3xl border border-gray-200 p-5 hover:shadow-lg transition-shadow">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $tagihan->jenis }} • {{ $tagihan->semester }}</p>
                                        <h4 class="text-lg font-semibold text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</h4>
                                        <p class="text-sm text-gray-500">Jatuh tempo: {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d F Y') }}</p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $tagihan->status === 'lunas' ? 'bg-green-100 text-green-800' : ($tagihan->status === 'cicilan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $tagihan->status)) }}
                                    </span>
                                    <div class="mt-4 lg:mt-2">
                                        <a href="{{ route('dashboard.mahasiswa.payment.form', $tagihan->id) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2 text-white text-sm font-semibold shadow-sm hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-credit-card"></i>
                                            Bayar Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500">Total Pembayaran Tertunda</p>
                <p class="mt-3 text-3xl font-semibold text-gray-800">Rp {{ number_format($tagihans->where('status', '!=', 'lunas')->sum('jumlah'), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500">Jumlah Tagihan Tersedia</p>
                <p class="mt-3 text-3xl font-semibold text-gray-800">{{ $tagihans->count() }}</p>
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Virtual Account</h4>
            <div class="rounded-3xl bg-blue-50 p-5">
                <p class="text-sm text-gray-500">{{ $virtualAccount['bank'] }}</p>
                <p class="text-2xl font-bold text-blue-700 mt-3">{{ $virtualAccount['number'] }}</p>
                <p class="text-sm text-gray-500 mt-2">Atas nama: {{ $virtualAccount['holder'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Kadaluwarsa: {{ $virtualAccount['expired'] }}</p>
            </div>
            <button class="mt-6 w-full rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                <i class="fas fa-copy mr-2"></i>Salin Nomor VA
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Status Pembayaran</span>
                    <span>{{ $tagihans->groupBy('status')->map->count()->get('belum_lunas', 0) }} belum lunas</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Total Upload Bukti</span>
                    <span>{{ $tagihans->sum(fn($item) => $item->pembayarans->count()) }} bukti</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Metode Utama</span>
                    <span>E-Wallet / Bank</span>
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection
