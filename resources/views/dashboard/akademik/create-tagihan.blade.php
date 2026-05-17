@extends('layouts.app')

@section('title', 'Tambah Tagihan - SIPATU')

@section('header_title', 'Tambah Tagihan')
@section('header_subtitle', 'Buat tagihan baru untuk mahasiswa')

@section('content')
<div>
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('dashboard.akademik.show-mahasiswa', $mahasiswa->id) }}" class="text-blue-600 hover:text-blue-700 mb-6 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Detail Mahasiswa
        </a>

        <!-- Form Card -->
        <div class="card p-3 p-md-4">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Buat Tagihan Baru</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Untuk: <span class="font-semibold">{{ $mahasiswa->nama }}</span> (NIM: <span class="font-semibold">{{ $mahasiswa->nim }}</span>)
                </p>
            </div>

            <form method="POST" action="{{ route('dashboard.akademik.mahasiswa.tagihan.store', $mahasiswa->id) }}">
                @csrf

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jenis Tagihan *</label>
                        <select name="jenis" required class="form-control @error('jenis') is-invalid @enderror">
                            <option value="">Pilih Jenis Tagihan</option>
                            <option value="UKT" {{ old('jenis') == 'UKT' ? 'selected' : '' }}>UKT (Uang Kuliah Tunggal)</option>
                            <option value="SPP" {{ old('jenis') == 'SPP' ? 'selected' : '' }}>SPP (Sumbangan Pengembangan Pendidikan)</option>
                            <option value="DENDA" {{ old('jenis') == 'DENDA' ? 'selected' : '' }}>DENDA (Denda Keterlambatan)</option>
                            <option value="LAINNYA" {{ old('jenis') == 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
                        </select>
                        @error('jenis')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Semester/Bulan *</label>
                        <input type="text" name="semester" value="{{ old('semester') }}" required placeholder="Contoh: Semester 1, Bulan Januari" class="form-control @error('semester') is-invalid @enderror">
                        @error('semester')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jumlah Tagihan (Rp) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                            <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="1000" step="1000" placeholder="Contoh: 5000000" class="form-control pl-10 @error('jumlah') is-invalid @enderror">
                        </div>
                        @error('jumlah')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum Rp 1.000</p>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Tanggal Jatuh Tempo *</label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" required class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror">
                        @error('tanggal_jatuh_tempo')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="card p-3 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-semibold text-blue-900">Informasi</p>
                            <p class="text-sm text-blue-700">Tagihan akan dibuat dengan status "Belum Lunas". Mahasiswa dapat melakukan pembayaran dan tagihan akan diverifikasi oleh admin keuangan.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100 w-md-auto">
                            <i class="fas fa-save"></i> Buat Tagihan
                        </button>
                        <a href="{{ route('dashboard.akademik.show-mahasiswa', $mahasiswa->id) }}" class="btn btn-secondary w-100 w-md-auto mt-3 md:mt-0">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Recent Tagihans Info -->
        <div class="mt-6 bg-gray-50 rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Tagihan Terbaru Mahasiswa</h3>
            @if($mahasiswa->tagihans->count() > 0)
            <div class="space-y-2">
                @foreach($mahasiswa->tagihans->take(5) as $tagihan)
                <div class="flex items-center justify-between text-sm bg-white p-3 rounded border border-gray-200">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $tagihan->jenis }} - {{ $tagihan->semester }}</p>
                        <p class="text-xs text-gray-500">Jatuh Tempo: {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                        <p class="text-xs">
                            @if($tagihan->status === 'lunas')
                            <span class="text-green-600 font-semibold">Lunas</span>
                            @elseif($tagihan->status === 'cicilan')
                            <span class="text-blue-600 font-semibold">Cicilan</span>
                            @else
                            <span class="text-red-600 font-semibold">Belum Lunas</span>
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500">Belum ada tagihan untuk mahasiswa ini</p>
            @endif
        </div>
    </div>
</div>
@endsection
