@extends('layouts.app')

@section('title', 'Kelola Tagihan Akademik - SIPATU')

@section('header_title', 'Kelola Tagihan')
@section('header_subtitle', 'Daftar dan kelola tagihan mahasiswa')

@section('content')
<div>
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="hidden lg:block">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Tagihan</h1>
            <p class="text-gray-600">Daftar tagihan mahasiswa berdasarkan jenis dan status.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        <div class="p-4 border-b border-gray-100 bg-gray-50 text-sm text-gray-600">
            Jumlah tagihan: {{ $tagihans->total() }}
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-white text-gray-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">NIM</th>
                        <th class="px-4 py-3">Nama Mahasiswa</th>
                        <th class="px-4 py-3">Jenis Tagihan</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Dibuat</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($tagihans as $tagihan)
                        <tr>
                            <td class="px-4 py-4 text-gray-700">{{ $tagihan->mahasiswa->nim ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-700">{{ $tagihan->mahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                            <td class="px-4 py-4 text-gray-700">{{ ucfirst(str_replace('_', ' ', $tagihan->jenis)) }}</td>
                            <td class="px-4 py-4 text-gray-700">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $tagihan->status === 'lunas' ? 'bg-emerald-100 text-emerald-700' : ($tagihan->status === 'cicilan' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ ucfirst(str_replace('_', ' ', $tagihan->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-500">{{ $tagihan->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4">
                                @if($tagihan->status !== 'lunas')
                                <form action="{{ route('dashboard.akademik.tagihan.remind', $tagihan->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Kirim Pengingat">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada tagihan yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 bg-white p-4">
            {{ $tagihans->links() }}
        </div>
    </div>
</div>
@endsection
