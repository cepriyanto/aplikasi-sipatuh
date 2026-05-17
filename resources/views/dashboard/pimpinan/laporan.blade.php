@extends('layouts.app')

@section('title', 'Laporan Keuangan - SIPATU')

@section('header_title', 'Laporan Keuangan')
@section('header_subtitle', 'Laporan pembayaran dan pemasukan')

@section('content')
<div>
    <!-- Header with Export Buttons -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="hidden lg:block">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan</h1>
            <p class="text-gray-600">Analisis pemasukan dan pembayaran</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="{{ route('dashboard.pimpinan.export-pdf', request()->only(['tanggal_awal', 'tanggal_akhir', 'status'])) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
            <a href="{{ route('dashboard.pimpinan.export-excel', request()->only(['tanggal_awal', 'tanggal_akhir', 'status'])) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pending -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Ditolak -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalDitolak, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card p-3 p-md-4 mb-6">
        <form method="GET" action="{{ route('dashboard.pimpinan.laporan') }}">
            <div class="row">
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control">
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control">
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto mb-3">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.pimpinan.laporan') }}" class="btn btn-secondary w-100 w-md-auto">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary by Semester -->
    @if($bySemester->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan per Semester</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($bySemester as $semester => $data)
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-700 font-semibold">{{ $semester }}</p>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ $data['count'] }} transaksi</p>
                <p class="text-sm text-blue-600 mt-1">Rp {{ number_format($data['total'], 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Pembayaran Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Detail Pembayaran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis Tagihan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Semester</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Metode</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pembayarans as $pembayaran)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $pembayaran->tanggal_bayar->format('d M Y') }}</td>
                        <td class="px-6 py-3 text-sm text-gray-800 font-medium">{{ $pembayaran->tagihan->mahasiswa->nama }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $pembayaran->tagihan->jenis }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $pembayaran->tagihan->semester }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ ucfirst($pembayaran->metode) }}</td>
                        <td class="px-6 py-3 text-sm">
                            @if($pembayaran->status_verifikasi === 'diterima')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Diterima</span>
                            @elseif($pembayaran->status_verifikasi === 'ditolak')
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p>Tidak ada data pembayaran</p>
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
