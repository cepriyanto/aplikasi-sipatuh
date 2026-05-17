@extends('layouts.app')

@section('title', 'Tambah Tagihan - SIPATU')
@section('header_title', 'Tambah Tagihan')
@section('header_subtitle', 'Input tagihan baru untuk mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="max-w-2xl">
        <div class="card p-3 p-md-4">
            <form method="POST" action="{{ route('dashboard.admin.keuangan.tagihan.store') }}">
                @csrf

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Pilih Mahasiswa</label>
                        <select name="mahasiswa_id" class="form-control @error('mahasiswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @forelse($mahasiswas ?? [] as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}">{{ optional($mahasiswa)->nama ?? 'Unknown' }} ({{ optional($mahasiswa)->nim ?? '-' }})</option>
                            @empty
                                <option disabled>Tidak ada data mahasiswa</option>
                            @endforelse
                        </select>
                        @error('mahasiswa_id')
                            <p class="validation-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jenis Tagihan</label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="UKT" {{ old('jenis') === 'UKT' ? 'selected' : '' }}>UKT (Uang Kuliah Tunggal)</option>
                            <option value="SPP" {{ old('jenis') === 'SPP' ? 'selected' : '' }}>SPP (Sumbangan Pengembangan Pendidikan)</option>
                            <option value="DENDA" {{ old('jenis') === 'DENDA' ? 'selected' : '' }}>DENDA</option>
                            <option value="LAINNYA" {{ old('jenis') === 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
                        </select>
                        @error('jenis')
                            <p class="validation-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Semester / Bulan</label>
                        <input type="text" name="semester" value="{{ old('semester') }}" placeholder="Contoh: Genap 2025 / April 2026" class="form-control @error('semester') is-invalid @enderror" required>
                        @error('semester')
                            <p class="validation-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" placeholder="Contoh: 2500000" class="form-control @error('jumlah') is-invalid @enderror" min="1000" step="1000" required>
                        @error('jumlah')
                            <p class="validation-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" required>
                        @error('tanggal_jatuh_tempo')
                            <p class="validation-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100 w-md-auto">
                            <i class="fas fa-save"></i> Simpan Tagihan
                        </button>
                        <a href="{{ route('dashboard.admin.keuangan.tagihans') }}" class="btn btn-secondary w-100 w-md-auto mt-3 md:mt-0">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
        </div>
    </div>
</div>
@endsection
