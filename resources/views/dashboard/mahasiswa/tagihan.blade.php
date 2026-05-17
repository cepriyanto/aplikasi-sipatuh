@extends('layouts.app')

@section('title', 'Tagihan - SIPATU')
@section('header_title', 'Tagihan')
@section('header_subtitle', 'Daftar tagihan mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="card p-3 p-md-4 mb-6">
        <form method="GET">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Semester</label>
                    <input type="text" name="semester" value="{{ request('semester') }}" placeholder="Cari semester" class="form-control">
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="cicilan" {{ request('status') === 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                        <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Jenis atau nominal" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('dashboard.mahasiswa.tagihan') }}" class="btn btn-secondary w-100 w-md-auto mt-3 md:mt-0">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice-dollar text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Sudah Lunas</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Cicilan</p>
                    <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($totalCicilan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Belum Lunas</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Periode</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nominal</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $tagihan)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-600">{{ $loop->iteration + ($tagihans->currentPage() - 1) * $tagihans->perPage() }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $tagihan->jenis }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $tagihan->jenis)) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ $tagihan->semester }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d F Y') }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $tagihan->status === 'lunas' ? 'bg-green-100 text-green-800' : ($tagihan->status === 'cicilan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $tagihan->status)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($tagihan->status !== 'lunas')
                                    <a href="{{ route('dashboard.mahasiswa.payment.form', $tagihan->id) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-white text-sm font-semibold hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-credit-card"></i>
                                        Bayar
                                    </a>
                                @else
                                    <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm text-gray-600" disabled>
                                        <i class="fas fa-check"></i>
                                        Lunas
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">Tidak ada tagihan untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 items-center justify-between border-t border-gray-100 px-6 py-4 md:flex-row">
            <p class="text-sm text-gray-500">Menampilkan {{ $tagihans->count() }} dari {{ method_exists($tagihans, 'total') ? $tagihans->total() : $tagihans->count() }} tagihan</p>
            @if(method_exists($tagihans, 'links'))
                {{ $tagihans->links() }}
            @endif
        </div>
    </div>
</div>
@endsection