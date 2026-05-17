@extends('layouts.app')

@section('title', 'Notifikasi - SIPATU')
@section('header_title', 'Notifikasi')
@section('header_subtitle', 'Daftar notifikasi untuk pembayaran dan tagihan Anda')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Notifikasi Anda</h3>
            <p class="text-sm text-gray-500">{{ $unreadCount }} notifikasi belum dibaca.</p>
        </div>
        <form action="{{ route('dashboard.mahasiswa.notifikasi.readAll') }}" method="POST" class="shrink-0">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-white text-sm font-semibold hover:bg-blue-700 transition-colors">
                <i class="fas fa-check-double"></i>
                Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($notifikasis as $notifikasi)
            <div class="rounded-3xl border p-6 shadow-sm transition hover:shadow-lg @if($notifikasi->type === 'warning') border-amber-200 bg-amber-50 @elseif($notifikasi->type === 'danger') border-rose-200 bg-rose-50 @else border-emerald-200 bg-emerald-50 @endif">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-sm font-semibold @if($notifikasi->type === 'warning') text-amber-800 @elseif($notifikasi->type === 'danger') text-rose-800 @else text-emerald-800 @endif">{{ $notifikasi->judul }}</span>
                            @if($notifikasi->status === 'belum')
                                <span class="rounded-full @if($notifikasi->type === 'warning') bg-amber-200/50 text-amber-800 @elseif($notifikasi->type === 'danger') bg-rose-200/50 text-rose-800 @else bg-emerald-200/50 text-emerald-800 @endif px-3 py-1 text-xs font-medium">Baru</span>
                            @else
                                <span class="rounded-full bg-black/5 px-3 py-1 text-xs font-medium text-gray-600">Dibaca</span>
                            @endif
                        </div>
                        <p class="text-sm @if($notifikasi->type === 'warning') text-amber-700 @elseif($notifikasi->type === 'danger') text-rose-700 @else text-emerald-700 @endif">{{ $notifikasi->pesan }}</p>
                    </div>
                    <div class="flex flex-col items-end gap-3 text-right text-sm @if($notifikasi->type === 'warning') text-amber-600 @elseif($notifikasi->type === 'danger') text-rose-600 @else text-emerald-600 @endif">
                        <span>{{ $notifikasi->created_at->diffForHumans() }}</span>
                        @if($notifikasi->status === 'belum')
                            <form action="{{ route('dashboard.mahasiswa.notifikasi.read', $notifikasi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-full bg-slate-100 px-3 py-1 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition">Tandai dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-10 text-center text-gray-500">
                Tidak ada notifikasi untuk ditampilkan.
            </div>
        @endforelse
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6">
        {{ $notifikasis->links() }}
    </div>
</div>
@endsection
