@extends('layouts.app')

@section('title', 'Tambah Mahasiswa - SIPATU')

@section('header_title', 'Tambah Mahasiswa')
@section('header_subtitle', 'Tambahkan mahasiswa baru ke sistem')

@section('content')
<div>
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('dashboard.akademik.mahasiswas') }}" class="text-blue-600 hover:text-blue-700 mb-6 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <!-- Form Card -->
        <div class="card p-3 p-md-4">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Form Tambah Mahasiswa</h2>
                <p class="text-sm text-gray-500 mt-1">Isi semua kolom yang ditandai dengan *</p>
            </div>

            <form method="POST" action="{{ route('dashboard.akademik.mahasiswa.store') }}">
                @csrf

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Nomor Induk Mahasiswa (NIM) *</label>
                        <input type="text" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 2021001" class="form-control @error('nim') is-invalid @enderror">
                        @error('nim')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="nama" value="">

                    <div class="col-12 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Password *</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="form-control pr-10 @error('password') is-invalid @enderror">
                            <button type="button" onclick="togglePassword('password', 'passwordIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                                <i id="passwordIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password *</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password" class="form-control pr-10">
                            <button type="button" onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                                <i id="confirmPasswordIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jurusan *</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" required placeholder="Contoh: Teknik Informatika" class="form-control @error('jurusan') is-invalid @enderror">
                        @error('jurusan')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Angkatan *</label>
                        <input type="number" name="angkatan" value="{{ old('angkatan', date('Y')) }}" required min="2000" max="2100" placeholder="Contoh: 2023" class="form-control @error('angkatan') is-invalid @enderror">
                        @error('angkatan')
                        <p class="validation-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100 w-md-auto">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('dashboard.akademik.mahasiswas') }}" class="btn btn-secondary w-100 w-md-auto">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-fill nama field with name value
    document.querySelector('input[name="name"]').addEventListener('change', function() {
        document.querySelector('input[name="nama"]').value = this.value;
    });

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
