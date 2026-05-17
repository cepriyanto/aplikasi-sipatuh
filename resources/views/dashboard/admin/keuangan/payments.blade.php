@extends('layouts.app')

@section('title', 'Kelola Pembayaran - SIPATU')
@section('header_title', 'Kelola Pembayaran')
@section('header_subtitle', 'Verifikasi dan kelola pembayaran mahasiswa')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card p-3 p-md-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Pembayaran</h3>
        <form method="GET">
            <div class="row">
                <!-- Status Filter -->
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Tanggal Awal -->
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control">
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control">
                </div>

                <!-- Submit -->
                <div class="col-12 col-md-3 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Payments Mobile Cards -->
    <div class="md:hidden space-y-4">
        @forelse($payments as $payment)
            <article class="rounded-3xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-gray-500">{{ optional($payment->tanggal_bayar)->format('d M Y') ?? '-' }}</p>
                        <p class="mt-2 font-semibold text-gray-800">{{ optional($payment->tagihan->mahasiswa)->nama ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">{{ optional($payment->tagihan->mahasiswa)->nim ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Jumlah</p>
                        <p class="mt-1 font-semibold text-gray-800">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-gray-600">
                    <div>
                        <p class="font-medium text-gray-800">Jenis Tagihan</p>
                        <p>{{ optional($payment->tagihan)->jenis ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Status</p>
                        @php
                            $status = $payment->status_verifikasi ?? 'pending';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $status === 'diterima' ? 'bg-green-100 text-green-800' : ($status === 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <a href="{{ route('dashboard.admin.keuangan.verify', $payment->id) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-check-circle"></i>
                        Verifikasi
                    </a>
                    <button class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition-colors">
                        <i class="fas fa-eye"></i>
                        Detail
                    </button>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-gray-200 bg-white p-6 text-center text-gray-500">
                Tidak ada data pembayaran.
            </div>
        @endforelse
    </div>

    <!-- Payments Table -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Mahasiswa</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal Bayar</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-600">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ optional($payment->tagihan->mahasiswa)->nama ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ optional($payment->tagihan->mahasiswa)->nim ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-700">{{ optional($payment->tagihan)->jenis ?? '-' }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-800">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ optional($payment->tanggal_bayar)->format('d M Y') ?? '-' }}</td>
                            <td class="py-4 px-6">
                                @php
                                    $status = $payment->status_verifikasi ?? 'pending';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $status === 'diterima' ? 'bg-green-100 text-green-800' : ($status === 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('dashboard.admin.keuangan.verify', $payment->id) }}" class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <button class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                Tidak ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col gap-3 items-start justify-between px-6 py-4 border-t border-gray-100 md:flex-row md:items-center">
            <p class="text-sm text-gray-500">Menampilkan {{ $payments->count() }} dari {{ method_exists($payments, 'total') ? $payments->total() : $payments->count() }} pembayaran</p>
            @if(method_exists($payments, 'links'))
                {{ $payments->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
