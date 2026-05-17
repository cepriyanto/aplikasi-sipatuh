@extends('layouts.app')

@section('title', 'Riwayat Pembayaran - SIPATU')
@section('header_title', 'Riwayat Pembayaran')
@section('header_subtitle', 'Histori semua pembayaran mahasiswa')

@section('content')
<!-- Filter & Search -->
<div class="card p-3 p-md-4 mb-6">
    <form>
        <div class="row">
            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">Tahun</label>
                <select class="form-control">
                    <option>Semua Tahun</option>
                    <option>2026</option>
                    <option>2025</option>
                    <option>2024</option>
                </select>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">Bulan</label>
                <select class="form-control">
                    <option>Semua Bulan</option>
                    <option>April</option>
                    <option>Maret</option>
                    <option>Februari</option>
                    <option>Januari</option>
                </select>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-control">
                    <option>Semua Jenis</option>
                    <option>UKT</option>
                    <option>SPP</option>
                    <option>PKM</option>
                </select>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">Cari</label>
                <div class="relative">
                    <input type="text" placeholder="Cari riwayat..." class="form-control pl-10">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div class="col-12 mb-3">
                <button class="btn btn-secondary w-100 w-md-auto">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">12</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-receipt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Pembayaran</p>
                <p class="text-2xl font-bold text-green-600">Rp 8.500.000</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Tahun Ini</p>
                <p class="text-2xl font-bold text-blue-600">Rp 3.500.000</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Bulan Ini</p>
                <p class="text-2xl font-bold text-purple-600">Rp 500.000</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-wallet text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nominal</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Metode</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Bukti</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">1</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">15 April 2026</p>
                        <p class="text-sm text-gray-500">10:30:45</p>
                    </td>
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
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6 text-gray-600">VA BCA</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Berhasil</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 2 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">2</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">10 Maret 2026</p>
                        <p class="text-sm text-gray-500">14:22:18</p>
                    </td>
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
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6 text-gray-600">VA BCA</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Berhasil</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 3 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">3</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">12 Februari 2026</p>
                        <p class="text-sm text-gray-500">09:15:33</p>
                    </td>
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
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6 text-gray-600">Transfer BCA</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Berhasil</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 4 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">4</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">10 Januari 2026</p>
                        <p class="text-sm text-gray-500">11:20:10</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Januari 2026</p>
                                <p class="text-sm text-gray-500">Sumbangan Pembinaan Pendidikan</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6 text-gray-600">VA Mandiri</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Berhasil</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 5 -->
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">5</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">5 Desember 2025</p>
                        <p class="text-sm text-gray-500">08:45:22</p>
                    </td>
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
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 350.000</td>
                    <td class="py-4 px-6 text-gray-600">Transfer BRI</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Berhasil</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
        <p class="text-sm text-gray-500">Menampilkan 1-5 dari 12 riwayat</p>
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
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-wallet text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal Bayar</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jenis Tagihan</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Metode</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No. Referensi</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">1</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">15 Jan 2025</p>
                        <p class="text-sm text-gray-500">10:30:45</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Bulan Ini</p>
                                <p class="text-sm text-gray-500">Januari 2025</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Transfer BCA</td>
                    <td class="py-4 px-6 text-gray-600 font-mono text-sm">TRX/2025/0115/001</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6"><span class="status-lunas">Berhasil</span></td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 2 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">2</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">10 Des 2024</p>
                        <p class="text-sm text-gray-500">14:22:18</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Bulan Lalu</p>
                                <p class="text-sm text-gray-500">Desember 2024</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Transfer BCA</td>
                    <td class="py-4 px-6 text-gray-600 font-mono text-sm">TRX/2024/1210/002</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6"><span class="status-lunas">Berhasil</span></td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 3 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">3</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">15 Nov 2024</p>
                        <p class="text-sm text-gray-500">09:15:33</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dna text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">PKM</p>
                                <p class="text-sm text-gray-500">Semester 5</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Transfer Mandiri</td>
                    <td class="py-4 px-6 text-gray-600 font-mono text-sm">TRX/2024/1115/003</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 350.000</td>
                    <td class="py-4 px-6"><span class="status-lunas">Berhasil</span></td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 4 -->
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">4</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">10 Okt 2024</p>
                        <p class="text-sm text-gray-500">16:45:22</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">SPP Oktober</p>
                                <p class="text-sm text-gray-500">Oktober 2024</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Transfer BCA</td>
                    <td class="py-4 px-6 text-gray-600 font-mono text-sm">TRX/2024/1010/004</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 500.000</td>
                    <td class="py-4 px-6"><span class="status-lunas">Berhasil</span></td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 5 -->
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-600">5</td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-800">12 Sep 2024</p>
                        <p class="text-sm text-gray-500">11:20:10</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">UKT Semester 3</p>
                                <p class="text-sm text-gray-500">Genap 2023/2024</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">Transfer BNI</td>
                    <td class="py-4 px-6 text-gray-600 font-mono text-sm">TRX/2024/0912/005</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">Rp 2.000.000</td>
                    <td class="py-4 px-6"><span class="status-lunas">Berhasil</span></td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700" title="Lihat Kwitansi">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
        <p class="text-sm text-gray-500">Menampilkan 1-5 dari 15 riwayat</p>
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