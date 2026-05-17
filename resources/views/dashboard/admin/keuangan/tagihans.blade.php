@extends('layouts.app')

@section('title', 'Kelola Tagihan - SIPATU')
@section('header_title', 'Kelola Tagihan')
@section('header_subtitle', 'Input dan kelola tagihan mahasiswa')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Action Button -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard.admin.keuangan.tagihan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-plus"></i>Tambah Tagihan
        </a>
    </div>

    <!-- Tagihans Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Mahasiswa</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $tagihan)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-600">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-800">{{ optional($tagihan->mahasiswa)->nama ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ optional($tagihan->mahasiswa)->nim ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 text-gray-700">{{ $tagihan->jenis }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-800">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ optional($tagihan->tanggal_jatuh_tempo)->format('d M Y') ?? '-' }}</td>
                            <td class="py-4 px-6">
                                @if($tagihan->status === 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Lunas</span>
                                @elseif($tagihan->status === 'cicilan')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Cicilan</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 flex items-center gap-2">
                                <button class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($tagihan->status !== 'lunas')
                                <form action="{{ route('dashboard.admin.keuangan.tagihan.remind', $tagihan->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-100 rounded-lg transition" title="Kirim Pengingat">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                Tidak ada data tagihan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
