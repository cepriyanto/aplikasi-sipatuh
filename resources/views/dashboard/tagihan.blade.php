@extends('layouts.app')

@section('title', 'Tagihan - SIPATU')
@section('header_title', 'Tagihan')
@section('header_subtitle', 'Daftar tagihan mahasiswa')

@section('content')
<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <select class="border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua Semester</option>
                <option>Genap 2025/2026</option>
                <option>Ganjil 2025/2026</option>
                <option>Genap 2024/2025</option>
            </select>
            
            <select class="border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua Status</option>
                <option>Lunas</option>
                <option>Belum Lunas</option>
                <option>Menunggu Konfirmasi</option>
            </select>
        </div>
        
        <div class="relative">
            <input type="text" placeholder="Cari tagihan..." class="w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Tagihan</p>
                <p class="text-2xl font-bold text-gray-800">Rp 5.500.000</p>
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
                <p class="text-2xl font-bold text-green-600">Rp 3.000.000</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Belum Lunas</p>
                <p class="text-2xl font-bold text-red-600">Rp 2.500.000</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Menunggu</p>
                <p class="text-2xl font-bold text-orange-600">Rp 0</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tagihan Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Periode</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nominal</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Aksi Bayar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 - Belum Lunas -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">1</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-red-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">UKT Semester 6</p>
                                <p class="text-sm text-gray-500">Uang Kuliah Tunggal</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Genap 2025/2026</td>
                    <td class="py-4 px-6 text-gray-600">28 Feb 2026</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 2.500.000</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Belum Lunas</span>
                    </td>
                    <td class="py-4 px-6">
                        <a href="{{ route('dashboard.mahasiswa.pembayaran') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-credit-card"></i>
                            Bayar
                        </a>
                    </td>
                </tr>
                
                <!-- Row 2 - Lunas -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">2</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP April 2026</p>
                                <p class="text-sm text-gray-500">Sumbangan Pembinaan Pendidikan</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">April 2026</td>
                    <td class="py-4 px-6 text-gray-600">30 Apr 2026</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Lunas</span>
                    </td>
                    <td class="py-4 px-6">
                        <button class="p-2 text-gray-400 hover:text-blue-600" title="Lihat Kwitansi">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Row 3 - Lunas -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">3</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Maret 2026</p>
                                <p class="text-sm text-gray-500">Sumbangan Pembinaan Pendidikan</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Maret 2026</td>
                    <td class="py-4 px-6 text-gray-600">31 Mar 2026</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Lunas</span>
                    </td>
                    <td class="py-4 px-6">
                        <button class="p-2 text-gray-400 hover:text-blue-600" title="Lihat Kwitansi">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Row 4 - Lunas -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">4</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Februari 2026</p>
                                <p class="text-sm text-gray-500">Sumbangan Pembinaan Pendidikan</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Februari 2026</td>
                    <td class="py-4 px-6 text-gray-600">28 Feb 2026</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Lunas</span>
                    </td>
                    <td class="py-4 px-6">
                        <button class="p-2 text-gray-400 hover:text-blue-600" title="Lihat Kwitansi">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Row 5 - Lunas -->
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">5</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dna text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">PKM</p>
                                <p class="text-sm text-gray-500">Pengembangan Kepribadian Mahasiswa</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Genap 2025/2026</td>
                    <td class="py-4 px-6 text-gray-600">15 Mar 2026</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 350.000</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Lunas</span>
                    </td>
                    <td class="py-4 px-6">
                        <button class="p-2 text-gray-400 hover:text-blue-600" title="Lihat Kwitansi">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
        <p class="text-sm text-gray-500">Menampilkan 1-5 dari 15 tagihan</p>
        <div class="flex items-center gap-2">
            <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 disabled:opacity-50" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">1</button>
            <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">3</button>
            <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
@endsection