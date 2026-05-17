@extends('layouts.app')

@section('title', 'Dashboard Akademik - SIPATU')

@section('header_title', 'Dashboard Akademik')
@section('header_subtitle', 'Kelola data mahasiswa dan tagihan')

@section('content')
<div>
    <!-- Welcome Section -->
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Bagian Akademik</h1>
        <p class="text-gray-600">Kelola data mahasiswa dan tagihan</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalMahasiswa }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- By Jurusan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Jurusan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $mahasiswaByJurusan->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- By Angkatan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Angkatan Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $mahasiswaByAngkatan->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Tagihan Belum Lunas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Belum Lunas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $tagihanSummary['belum_lunas'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
        <a href="{{ route('dashboard.akademik.mahasiswas') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Kelola Mahasiswa</h3>
                    <p class="text-sm text-gray-500">Tambah, edit, hapus data mahasiswa</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.akademik.tagihan') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Kelola Tagihan</h3>
                    <p class="text-sm text-gray-500">Buat tagihan berdasarkan semester</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Mahasiswa by Jurusan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Mahasiswa per Jurusan</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($mahasiswaByJurusan as $jurusan)
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-800">{{ $jurusan->total }}</p>
                    <p class="text-sm text-gray-500">{{ $jurusan->jurusan }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mahasiswa by Angkatan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Mahasiswa per Angkatan</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-4">
                @foreach($mahasiswaByAngkatan as $angkatan)
                <div class="text-center p-4 bg-blue-50 rounded-lg min-w-[100px]">
                    <p class="text-2xl font-bold text-blue-600">{{ $angkatan->total }}</p>
                    <p class="text-sm text-gray-600">{{ $angkatan->angkatan }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection