@extends('layouts.app')

@section('title', 'Monitoring Pembayaran - SIPATU')

@section('header_title', 'Monitoring Pembayaran')
@section('header_subtitle', 'Pantau status pembayaran per mahasiswa')

@section('content')
<div>
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Monitoring Pembayaran Mahasiswa</h1>
        <p class="text-gray-600">Lihat status pembayaran dan pencapaian per mahasiswa</p>
    </div>

    <!-- Filters -->
    <div class="card p-3 p-md-4 mb-6">
        <form method="GET" action="{{ route('dashboard.pimpinan.monitoring') }}">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Angkatan</label>
                    <select name="angkatan" class="form-control">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto mb-3">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.pimpinan.monitoring') }}" class="btn btn-secondary w-100 w-md-auto">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Mahasiswa Monitoring Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Status Pembayaran Mahasiswa ({{ $mahasiswas->count() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No.</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama (NIM)</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jurusan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Angkatan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Tagihan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sudah Terbayar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sisa Tagihan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mahasiswas as $index => $mahasiswa)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-sm text-gray-800 font-medium">
                            {{ $mahasiswa->nama }} <br>
                            <span class="text-xs text-gray-500">({{ $mahasiswa->nim }})</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $mahasiswa->jurusan }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $mahasiswa->angkatan }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($mahasiswa->total_tagihan, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-green-600">Rp {{ number_format($mahasiswa->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-orange-600">Rp {{ number_format(max(0, $mahasiswa->total_tagihan - $mahasiswa->total_bayar), 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1">
                                    <!-- Progress Bar -->
                                    <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        @php
                                        $percentage = $mahasiswa->persentase;
                                        $bgColor = $percentage >= 100 ? 'bg-green-500' : ($percentage >= 75 ? 'bg-blue-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500'));
                                        @endphp
                                        <div class="{{ $bgColor }} h-full" style="width: {{ min($percentage, 100) }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold whitespace-nowrap">
                                    @if($mahasiswa->persentase >= 100)
                                    <span class="text-green-600">✓ {{ number_format($mahasiswa->persentase, 1) }}%</span>
                                    @elseif($mahasiswa->persentase >= 75)
                                    <span class="text-blue-600">{{ number_format($mahasiswa->persentase, 1) }}%</span>
                                    @elseif($mahasiswa->persentase >= 50)
                                    <span class="text-yellow-600">{{ number_format($mahasiswa->persentase, 1) }}%</span>
                                    @else
                                    <span class="text-red-600">{{ number_format($mahasiswa->persentase, 1) }}%</span>
                                    @endif
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p>Tidak ada data mahasiswa</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="mt-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Total Mahasiswa -->
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-blue-600">{{ $mahasiswas->count() }}</p>
            </div>

            <!-- Lunas (100%) -->
            <div>
                <p class="text-sm text-gray-600 mb-1">Pembayaran Selesai (100%)</p>
                <p class="text-3xl font-bold text-green-600">
                    {{ $mahasiswas->filter(fn($m) => $m->persentase >= 100)->count() }}
                </p>
            </div>

            <!-- Belum Selesai (<100%) -->
            <div>
                <p class="text-sm text-gray-600 mb-1">Pembayaran Belum Selesai</p>
                <p class="text-3xl font-bold text-orange-600">
                    {{ $mahasiswas->filter(fn($m) => $m->persentase < 100)->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
