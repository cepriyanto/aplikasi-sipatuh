@extends('layouts.app')

@section('title', 'Kelola Mahasiswa - SIPATU')

@section('header_title', 'Kelola Mahasiswa')
@section('header_subtitle', 'Tambah, edit, dan hapus data mahasiswa')

@section('content')
<div>
    <!-- Header with Add Button -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="hidden lg:block">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Mahasiswa</h1>
            <p class="text-gray-600">Kelola data mahasiswa akademik</p>
        </div>
        <a href="{{ route('dashboard.akademik.mahasiswa.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
            <i class="fas fa-plus"></i>
            Tambah Mahasiswa
        </a>
    </div>

    <!-- Filters -->
    <div class="card p-3 p-md-4 mb-6">
        <form method="GET" action="{{ route('dashboard.akademik.mahasiswas') }}">
            <div class="row">
                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Angkatan</label>
                    <select name="angkatan" class="form-control">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="cicilan" {{ request('status_pembayaran') == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                        <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3">
                    <button type="submit" class="btn btn-primary w-100 w-md-auto mb-3">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.akademik.mahasiswas') }}" class="btn btn-secondary w-100 w-md-auto">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Mahasiswa Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No.</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jurusan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Angkatan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($mahasiswas as $index => $mahasiswa)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-600">{{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $mahasiswa->nim }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $mahasiswa->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mahasiswa->jurusan }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mahasiswa->angkatan }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mahasiswa->user->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard.akademik.show-mahasiswa', $mahasiswa->id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition-colors" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('dashboard.akademik.mahasiswa.edit', $mahasiswa->id) }}" class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200 transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('dashboard.akademik.mahasiswa.destroy', $mahasiswa->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $mahasiswas->links('pagination::tailwind') }}
    </div>
</div>
@endsection
