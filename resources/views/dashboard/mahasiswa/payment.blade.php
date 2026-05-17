@extends('layouts.app')

@section('title', 'Bayar Tagihan - SIPATU')
@section('header_title', 'Bayar Tagihan')
@section('header_subtitle', 'Lengkapi data pembayaran dan unggah bukti transfer')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Tagihan {{ $tagihan->jenis }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="rounded-3xl bg-blue-50 p-4">
                    <p class="text-sm text-gray-500">Nominal Tagihan</p>
                    <p class="mt-2 text-2xl font-semibold text-blue-700">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-3xl bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">Jatuh Tempo</p>
                    <p class="mt-2 text-xl font-semibold text-gray-800">{{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d F Y') }}</p>
                </div>
            </div>

            <div class="card p-3 p-md-4">
                <h4 class="text-base font-semibold text-gray-800 mb-4">Form Pembayaran</h4>

                <form action="{{ route('dashboard.mahasiswa.payment.process', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Jumlah Bayar</label>
                            <input type="number" name="jumlah_bayar" value="{{ old('jumlah_bayar', $tagihan->sisa_bayar) }}" min="1000" max="{{ $tagihan->jumlah }}" placeholder="Masukkan jumlah pembayaran" class="form-control @error('jumlah_bayar') is-invalid @enderror">
                            @error('jumlah_bayar')<p class="validation-message">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode" class="form-control @error('metode') is-invalid @enderror">
                                <option value="transfer_bank">Transfer Bank</option>
                                <option value="e_wallet">E-Wallet</option>
                                <option value="cash">Cash</option>
                            </select>
                            @error('metode')<p class="validation-message">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Unggah Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*,application/pdf">
                            @error('bukti_pembayaran')<p class="validation-message">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-12 mb-3">
                            <button type="submit" class="btn btn-primary w-100 w-md-auto">
                                <i class="fas fa-paper-plane"></i> Ajukan Pembayaran
                            </button>
                        </div>
                    </div>
                </form>
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
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Info Tagihan</h4>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-700"><i class="fas fa-check"></i></span>
                    Sisa bayar: Rp {{ number_format($tagihan->sisa_bayar, 0, ',', '.') }}
                </li>
                <li class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700"><i class="fas fa-calendar-alt"></i></span>
                    Status: {{ ucfirst(str_replace('_', ' ', $tagihan->status)) }}
                </li>
                <li class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 text-purple-700"><i class="fas fa-clock"></i></span>
                    Diajukan pada: {{ now()->format('d F Y') }}
                </li>
            </ul>
        </div>
    </aside>
</div>
@endsection
