@extends('layouts.app')

@section('title', 'Notifikasi - SIPATU')
@section('header_title', 'Notifikasi')
@section('header_subtitle', 'Daftar notifikasi melalui email, WhatsApp, dan SMS')

@section('content')
<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex rounded-lg bg-gray-100 p-1">
            <button class="px-4 py-2 bg-white text-blue-600 rounded-lg shadow-sm font-medium text-sm">
                <i class="fas fa-bell mr-2"></i>Semua
                <span class="ml-2 bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full">8</span>
            </button>
            <button class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium text-sm">
                <i class="fas fa-envelope mr-2"></i>Email
                <span class="ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-0.5 rounded-full">4</span>
            </button>
            <button class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium text-sm">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                <span class="ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-0.5 rounded-full">3</span>
            </button>
            <button class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium text-sm">
                <i class="fas fa-sms mr-2"></i>SMS
                <span class="ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-0.5 rounded-full">1</span>
            </button>
        </div>
        
        <div class="flex items-center gap-3">
            <select class="border border-gray-200 rounded-lg px-4 py-2 text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua Jenis</option>
                <option>Tagihan</option>
                <option>Pembayaran</option>
                <option>Pengumuman</option>
                <option>Reminder</option>
            </select>
            
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
            </button>
        </div>
    </div>
</div>

<!-- Notification List -->
<div class="space-y-4">
    <!-- Unread Notification 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-file-invoice-dollar text-red-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-800">Tagihan UKT Semester 6</h4>
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Anda memiliki tagihan UKT sebesar Rp 2.500.000 dengan jatuh tempo 28 Februari 2026. Segera lakukan pembayaran untuk menghindari denda keterlambatan.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>25 Apr 2026, 10:00</span>
                            <span><i class="fas fa-envelope mr-1"></i>Email</span>
                            <span><i class="fab fa-whatsapp mr-1"></i>WhatsApp</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Belum Dibaca</span>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600" title="Tandai Dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Unread Notification 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-800">Pembayaran Berhasil</h4>
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Pembayaran SPP April 2026 sebesar Rp 500.000 telah berhasil diverifikasi. Kwitansi pembayaran dapat diunduh di menu Riwayat.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>15 Apr 2026, 10:35</span>
                            <span><i class="fas fa-envelope mr-1"></i>Email</span>
                            <span><i class="fas fa-sms mr-1"></i>SMS</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Belum Dibaca</span>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600" title="Tandai Dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Unread Notification 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-semibold text-gray-800">Pengumuman: Jadwal Pembayaran</h4>
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Jadwal pembayaran SPP bulan Mei 2026 akan dimulai pada tanggal 1 Mei 2026. Dimohon untuk membayar tepat waktu.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>20 Apr 2026, 14:00</span>
                            <span><i class="fas fa-envelope mr-1"></i>Email</span>
                            <span><i class="fab fa-whatsapp mr-1"></i>WhatsApp</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Belum Dibaca</span>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600" title="Tandai Dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Read Notification 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow opacity-75">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-gray-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-medium text-gray-600">Pembayaran Berhasil</h4>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Pembayaran SPP Maret 2026 sebesar Rp 500.000 telah berhasil diverifikasi.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <span><i class="fas fa-clock mr-1"></i>10 Mar 2026, 14:25</span>
                            <span><i class="fas fa-envelope mr-1"></i>Email</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">Dibaca</span>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Read Notification 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow opacity-75">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-bell text-gray-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-medium text-gray-600">Reminder: Jatuh Tempo UKT</h4>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Reminder: Tagihan UKT semester ini akan jatuh tempo dalam 5 hari lagi.</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <span><i class="fas fa-clock mr-1"></i>23 Feb 2026, 09:00</span>
                            <span><i class="fab fa-whatsapp mr-1"></i>WhatsApp</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">Dibaca</span>
                        <div class="flex items-center gap-2">
                            <button class="p-2 text-gray-400 hover:text-gray-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="flex items-center justify-between mt-6">
    <p class="text-sm text-gray-500">Menampilkan 1-5 dari 8 notifikasi</p>
    <div class="flex items-center gap-2">
        <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 disabled:opacity-50" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">1</button>
        <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">2</button>
        <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
@endsection