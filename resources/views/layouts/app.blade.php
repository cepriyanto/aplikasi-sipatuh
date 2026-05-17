<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIPATU - Sistem Pembayaran Tagihan Mahasiswa">
    <title>@yield('title', 'SIPATU - Sistem Pembayaran Tagihan Mahasiswa')</title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        html, body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        
        .sidebar-link {
            @apply flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200;
        }
        
        .sidebar-link:hover {
            @apply bg-blue-50 text-blue-600;
        }
        
        .sidebar-link.active {
            @apply bg-blue-600 text-white;
        }
        
        .card-hover {
            @apply transition-all duration-300 hover:shadow-lg hover:-translate-y-1;
        }
        
        .status-lunas {
            @apply bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium;
        }
        
        .status-belum {
            @apply bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium;
        }
        
        .status-proses {
            @apply bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Bootstrap-style form helper classes */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.75rem;
        }
        .col-12,
        .col-md-6,
        .col-md-4,
        .col-md-3 {
            box-sizing: border-box;
            padding: 0 0.75rem;
            width: 100%;
        }
        .col-md-6 {
            width: 100%;
        }
        .col-md-4 {
            width: 100%;
        }
        .col-md-3 {
            width: 100%;
        }
        @media (min-width: 768px) {
            .col-md-6 {
                width: 50%;
            }
            .col-md-4 {
                width: 33.333333%;
            }
            .col-md-3 {
                width: 25%;
            }
        }
        
        /* Global Table Responsive Fix */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Force max-width on everything in mobile */
        @media (max-width: 767px) {
            .grid {
                max-width: 100vw;
            }
            main {
                max-width: 100vw;
                overflow-x: hidden;
            }
            /* Allow tables to still scroll despite main overflow-x-hidden */
            .overflow-x-auto {
                overflow-x: auto !important;
            }
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
        }
        .card p,
        .card label,
        .card input,
        .card select,
        .card textarea,
        .card button {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            background: #ffffff;
            color: #111827;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #334155;
        }
        .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            border-radius: 0.75rem;
            padding: 10px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #e2e8f0;
            color: #1f2937;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
        }
        .w-100 {
            width: 100% !important;
        }
        @media (min-width: 768px) {
            .w-md-auto {
                width: auto !important;
            }
        }
        .text-danger {
            color: #ef4444;
        }
        .validation-message {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc2626;
        }
        @media (max-width: 768px) {
            .form-control {
                font-size: 16px;
            }
            .btn {
                padding: 12px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    @php
        $notificationCount = auth()->check() ? auth()->user()->notifikasis()->belumDibaca()->count() : 0;
    @endphp

    <div id="sidebarBackdrop" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen max-w-full">
        @include('components.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 w-full min-w-0 lg:ml-64 relative">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-6">
                    <div class="flex items-center gap-3 min-w-0">
                        <button type="button" class="lg:hidden shrink-0 inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-100 transition" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-xl font-semibold text-gray-800 truncate">@yield('header_title', 'Dashboard')</h2>
                            <p class="text-xs sm:text-sm text-gray-500 truncate hidden sm:block">@yield('header_subtitle', 'Selamat datang di SIPATU')</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Search toggle (mobile) / inline (desktop) -->
                        <button class="sm:hidden p-2 text-gray-600 hover:text-blue-600 transition-colors" onclick="document.getElementById('searchBar').classList.toggle('hidden')" aria-label="Search">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                        <div class="relative hidden sm:block w-60 lg:w-72">
                            <input type="text" placeholder="Cari..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                        
                        <!-- Notifications -->
                        <a href="{{ route('dashboard.mahasiswa.notifikasi') }}" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-bell text-lg"></i>
                            @if($notificationCount > 0)
                                <span class="absolute -top-1 -right-1 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1.5 text-[10px] font-semibold text-white">{{ $notificationCount }}</span>
                            @else
                                <span class="absolute top-0 right-0 w-2 h-2 bg-slate-300 rounded-full"></span>
                            @endif
                        </a>
                        
                        <!-- Help -->
                        <button class="hidden sm:inline-flex p-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-question-circle text-lg"></i>
                        </button>
                    </div>
                </div>
                <!-- Mobile search bar (toggled) -->
                <div id="searchBar" class="hidden sm:hidden px-4 pb-3">
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-4 sm:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMobile');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (!sidebar || !backdrop) return;
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebarMobile');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (!sidebar || !backdrop) return;
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    </script>
    
    @yield('scripts')
</body>
</html>