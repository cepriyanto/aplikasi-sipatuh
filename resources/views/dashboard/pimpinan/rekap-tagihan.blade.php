@extends('layouts.app')

@section('title', 'Rekap Tagihan - SIPATU')

@section('header_title', 'Rekap Tagihan')
@section('header_subtitle', 'Ringkasan semua tagihan mahasiswa')

@section('content')
<div>
    <div class="hidden lg:block mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rekap Tagihan</h1>
        <p class="text-gray-600">Lihat ringkasan semua tagihan per semester dan jenis</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Total Tagihan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Lunas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tagihan Lunas</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($summary['lunas'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Cicilan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Dalam Cicilan</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($summary['cicilan'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Belum Lunas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Belum Lunas</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($summary['belum_lunas'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card p-3 p-md-4 mb-6">
        <form method="GET" action="{{ route('dashboard.pimpinan.rekap-tagihan') }}">
            <div class="row">
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-control">
                        <option value="">Semua Semester</option>
                        @foreach($semesters as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Jenis Tagihan</label>
                    <select name="jenis" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="UKT" {{ request('jenis') == 'UKT' ? 'selected' : '' }}>UKT</option>
                        <option value="SPP" {{ request('jenis') == 'SPP' ? 'selected' : '' }}>SPP</option>
                        <option value="DENDA" {{ request('jenis') == 'DENDA' ? 'selected' : '' }}>DENDA</option>
                        <option value="LAINNYA" {{ request('jenis') == 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="cicilan" {{ request('status') == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                        <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto mb-3">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.pimpinan.rekap-tagihan') }}" class="btn btn-secondary w-100 w-md-auto">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tagihan Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Tagihan ({{ $tagihans->count() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No.</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mahasiswa (NIM)</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Semester</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tagihans as $index => $tagihan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-sm text-gray-800 font-medium">
                            {{ $tagihan->mahasiswa->nama }} <br>
                            <span class="text-xs text-gray-500">({{ $tagihan->mahasiswa->nim }})</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $tagihan->jenis }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $tagihan->semester }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}</td>
                        <td class="px-6 py-3 text-sm">
                            @if($tagihan->status === 'lunas')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lunas</span>
                            @elseif($tagihan->status === 'cicilan')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Cicilan</span>
                            @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p>Tidak ada data tagihan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
