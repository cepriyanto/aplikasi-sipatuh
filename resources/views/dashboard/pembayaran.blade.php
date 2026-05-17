@extends('layouts.app')

@section('title', 'Pembayaran - SIPATU')
@section('header_title', 'Pembayaran')
@section('header_subtitle', 'Form dan konfirmasi pembayaran online')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Payment Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Form Pembayaran</h3>
            
            <form action="#" method="POST">
                @csrf
                
                <!-- Pilih Tagihan -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tagihan</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-blue-500 rounded-lg bg-blue-50 cursor-pointer">
                            <input type="radio" name="tagihan" value="ukt" class="w-5 h-5 text-blue-600 focus:ring-blue-500" checked>
                            <div class="ml-3 flex-1">
                                <p class="font-medium text-gray-800">UKT Semester 6</p>
                                <p class="text-sm text-gray-500">Uang Kuliah Tunggal - Genap 2025/2026</p>
                            </div>
                            <span class="text-lg font-semibold text-gray-800">Rp 2.500.000</span>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="tagihan" value="spp" class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3 flex-1">
                                <p class="font-medium text-gray-800">SPP Mei 2026</p>
                                <p class="text-sm text-gray-500">Sumbangan Pembinaan Pendidikan - Mei 2026</p>
                            </div>
                            <span class="text-lg font-semibold text-gray-800">Rp 500.000</span>
                        </label>
                    </div>
                </div>
                
                <!-- Metode Pembayaran -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                    
                    <p class="text-xs text-gray-500 mb-3">Transfer Bank</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <label class="flex flex-col items-center p-4 border-2 border-blue-500 rounded-lg bg-blue-50 cursor-pointer">
                            <input type="radio" name="metode" value="bca" class="sr-only" checked>
                            <div class="w-16 h-10 bg-blue-600 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">BCA</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">BCA</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="mandiri" class="sr-only">
                            <div class="w-16 h-10 bg-red-600 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">MANDIRI</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">Mandiri</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="bni" class="sr-only">
                            <div class="w-16 h-10 bg-orange-500 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">BNI</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">BNI</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="bri" class="sr-only">
                            <div class="w-16 h-10 bg-blue-800 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">BRI</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">BRI</span>
                        </label>
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-3">Virtual Account</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="va-bca" class="sr-only">
                            <div class="w-16 h-10 bg-blue-600 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">VA BCA</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">VA BCA</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="va-mandiri" class="sr-only">
                            <div class="w-16 h-10 bg-red-600 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">VA MANDIRI</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">VA Mandiri</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="va-bni" class="sr-only">
                            <div class="w-16 h-10 bg-orange-500 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">VA BNI</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">VA BNI</span>
                        </label>
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-3">E-Wallet</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="dana" class="sr-only">
                            <div class="w-16 h-10 bg-blue-400 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">DANA</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">DANA</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="ovo" class="sr-only">
                            <div class="w-16 h-10 bg-purple-600 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">OVO</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">OVO</span>
                        </label>
                        
                        <label class="flex flex-col items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="metode" value="gopay" class="sr-only">
                            <div class="w-16 h-10 bg-green-500 rounded flex items-center justify-center mb-2">
                                <span class="text-white text-xs font-bold">GOPAY</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">GoPay</span>
                        </label>
                    </div>
                </div>
                
                <!-- Nomor VA -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Nomor Virtual Account</p>
                            <p class="text-2xl font-bold text-blue-600">8828 1234 5678</p>
                        </div>
                        <button type="button" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-copy mr-2"></i>Salin
                        </button>
                    </div>
                </div>
                
                <!-- Total Pembayaran -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-700">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-gray-800">Rp 2.500.000</span>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    <i class="fas fa-lock mr-2"></i>Bayar Sekarang
                </button>
                
                <p class="text-center text-sm text-gray-500 mt-4">
                    <i class="fas fa-shield-alt mr-1"></i>Pembayaran aman dengan enkripsi SSL
                </p>
            </form>
        </div>
        
        <!-- Petunjuk Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Petunjuk Pembayaran</h3>
            
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-semibold">1</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Pilih tagihan yang akan dibayarkan</p>
                        <p class="text-sm text-gray-500">Pastikan tagihan yang dipilih sesuai dengan yang ingin Anda bayarkan</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-semibold">2</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Pilih metode pembayaran</p>
                        <p class="text-sm text-gray-500">Anda dapat membayar melalui bank, virtual account, atau e-wallet</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-semibold">3</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Transfer sesuai nominal</p>
                        <p class="text-sm text-gray-500">Transfer tepat sesuai jumlah yang tertera ke nomor Virtual Account</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-600 font-semibold">4</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Simpan bukti pembayaran</p>
                        <p class="text-sm text-gray-500">Setelah transfer, simpan bukti pembayaran untuk konfirmasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <!-- Virtual Account Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Virtual Account</h4>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg mb-4">
                <p class="text-sm text-gray-500 mb-1">BCA Virtual Account</p>
                <p class="text-2xl font-bold text-blue-600">8828 1234 5678</p>
            </div>
            
            <button class="w-full py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-copy mr-2"></i>Salin Nomor VA
            </button>
        </div>
        
        <!-- Info Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi</h4>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Batas Waktu</p>
                        <p class="font-medium text-gray-800">28 Feb 2026, 23:59</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-medium text-gray-800">Menunggu Pembayaran</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Mahasiswa</p>
                        <p class="font-medium text-gray-800">Dini Aprilianti (2121001)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection