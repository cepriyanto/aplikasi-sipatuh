@extends('layouts.app')

@section('title', 'Detail Mahasiswa - SIPATU')

@section('header_title', 'Detail Mahasiswa')
@section('header_subtitle', 'Lihat data dan tagihan mahasiswa')

@section('content')
<div>
    <!-- Back Button -->
    <a href="{{ route('dashboard.akademik.mahasiswas') }}" class="text-blue-600 hover:text-blue-700 mb-6 inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Mahasiswa Info -->
        <div class="lg:col-span-2">
            <!-- Mahasiswa Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $mahasiswa->nama }}</h2>
                            <p class="text-gray-600">NIM: <span class="font-semibold">{{ $mahasiswa->nim }}</span></p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('dashboard.akademik.mahasiswa.edit', $mahasiswa->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors font-medium">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <!-- Jurusan -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jurusan</p>
                            <p class="font-semibold text-gray-800">{{ $mahasiswa->jurusan }}</p>
                        </div>

                        <!-- Angkatan -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Angkatan</p>
                            <p class="font-semibold text-gray-800">{{ $mahasiswa->angkatan }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Email</p>
                            <p class="font-semibold text-gray-800">{{ $mahasiswa->user->email }}</p>
                        </div>

                        <!-- Total Tagihan -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Tagihan</p>
                            <p class="text-2xl font-bold text-red-600">{{ count($mahasiswa->tagihans) }}</p>
                        </div>

                        <!-- Total Terbayar -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Sudah Terbayar</p>
                            <p class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($mahasiswa->tagihans->sum(function($t) { return $t->pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar'); }), 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Belum Terbayar -->
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Belum Terbayar</p>
                            <p class="text-2xl font-bold text-orange-600">
                                Rp {{ number_format($mahasiswa->tagihans->sum(function($t) { 
                                    $bayar = $t->pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar');
                                    return max(0, $t->jumlah - $bayar);
                                }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tagihan List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Tagihan</h3>
                    <a href="{{ route('dashboard.akademik.mahasiswa.tagihan.create', $mahasiswa->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-center w-full sm:w-auto">
                        <i class="fas fa-plus mr-2"></i>Tambah Tagihan
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px]">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Semester</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Terbayar</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sisa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($mahasiswa->tagihans as $tagihan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $tagihan->jenis }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $tagihan->semester }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-green-600">
                                    Rp {{ number_format($tagihan->pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-sm font-medium text-orange-600">
                                    Rp {{ number_format(max(0, $tagihan->jumlah - $tagihan->pembayarans->where('status_verifikasi', 'diterima')->sum('jumlah_bayar')), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-sm">
                                    @if($tagihan->status === 'lunas')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lunas</span>
                                    @elseif($tagihan->status === 'cicilan')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Cicilan</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}</td>
                            </tr>

                            <!-- Pembayaran Sub-rows -->
                            @if(count($tagihan->pembayarans) > 0)
                            <tr class="bg-gray-50">
                                <td colspan="7" class="px-6 py-4">
                                    <div class="text-xs font-semibold text-gray-700 mb-3">Riwayat Pembayaran:</div>
                                    <div class="space-y-2">
                                        @foreach($tagihan->pembayarans as $pembayaran)
                                        <div class="flex items-center justify-between text-xs bg-white p-3 rounded border border-gray-200">
                                            <div class="flex-1">
                                                <p class="text-gray-700">
                                                    <span class="font-semibold">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                                                    - {{ $pembayaran->tanggal_bayar->format('d M Y') }} ({{ ucfirst($pembayaran->metode) }})
                                                </p>
                                            </div>
                                            <div>
                                                @if($pembayaran->status_verifikasi === 'diterima')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded font-semibold">Diterima</span>
                                                @elseif($pembayaran->status_verifikasi === 'ditolak')
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded font-semibold">Ditolak</span>
                                                @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded font-semibold">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endif

                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                        <p>Tidak ada tagihan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div>
            <!-- Status Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Status</h3>

                <div class="space-y-4">
                    <!-- Lunas -->
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-green-700">Tagihan Lunas</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $mahasiswa->tagihans->where('status', 'lunas')->count() }}
                        </p>
                    </div>

                    <!-- Cicilan -->
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-700">Dalam Cicilan</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $mahasiswa->tagihans->where('status', 'cicilan')->count() }}
                        </p>
                    </div>

                    <!-- Belum Lunas -->
                    <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                        <p class="text-sm text-red-700">Belum Lunas</p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ $mahasiswa->tagihans->where('status', 'belum_lunas')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pembayaran</h3>

                <div class="space-y-4">
                    <!-- Pending -->
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-sm text-yellow-700">Menunggu Verifikasi</p>
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $mahasiswa->tagihans->flatMap(fn($t) => $t->pembayarans)->where('status_verifikasi', 'pending')->count() }}
                        </p>
                    </div>

                    <!-- Diterima -->
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-green-700">Diterima</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $mahasiswa->tagihans->flatMap(fn($t) => $t->pembayarans)->where('status_verifikasi', 'diterima')->count() }}
                        </p>
                    </div>

                    <!-- Ditolak -->
                    <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                        <p class="text-sm text-red-700">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ $mahasiswa->tagihans->flatMap(fn($t) => $t->pembayarans)->where('status_verifikasi', 'ditolak')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
