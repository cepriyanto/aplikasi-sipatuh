@php
    $user = auth()->user();
    $unreadNotifications = $user ? $user->notifikasis()->belumDibaca()->count() : 0;

    $menuItems = match($user->role) {
        'mahasiswa' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.mahasiswa', 'icon' => 'fa-home', 'badge' => null],
            ['label' => 'Tagihan', 'route' => 'dashboard.mahasiswa.tagihan', 'icon' => 'fa-file-invoice', 'badge' => null],
            ['label' => 'Pembayaran', 'route' => 'dashboard.mahasiswa.pembayaran', 'icon' => 'fa-credit-card', 'badge' => null],
            ['label' => 'Riwayat', 'route' => 'dashboard.mahasiswa.riwayat', 'icon' => 'fa-history', 'badge' => null],
            ['label' => 'Notifikasi', 'route' => 'dashboard.mahasiswa.notifikasi', 'icon' => 'fa-bell', 'badge' => $unreadNotifications],
        ],
        'admin_keuangan' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.admin.keuangan', 'icon' => 'fa-home', 'badge' => null],
            ['label' => 'Kelola Pembayaran', 'route' => 'dashboard.admin.keuangan.payments', 'icon' => 'fa-credit-card', 'badge' => null],
            ['label' => 'Kelola Tagihan', 'route' => 'dashboard.admin.keuangan.tagihans', 'icon' => 'fa-file-invoice', 'badge' => null],
            ['label' => 'Laporan', 'route' => 'dashboard.admin.keuangan.laporan', 'icon' => 'fa-chart-bar', 'badge' => null],
        ],
        'admin' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.admin.keuangan', 'icon' => 'fa-home', 'badge' => null],
            ['label' => 'Kelola Pembayaran', 'route' => 'dashboard.admin.keuangan.payments', 'icon' => 'fa-credit-card', 'badge' => null],
            ['label' => 'Kelola Tagihan', 'route' => 'dashboard.admin.keuangan.tagihans', 'icon' => 'fa-file-invoice', 'badge' => null],
            ['label' => 'Laporan', 'route' => 'dashboard.admin.keuangan.laporan', 'icon' => 'fa-chart-bar', 'badge' => null],
        ],
        'akademik' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.akademik', 'icon' => 'fa-home', 'badge' => null],
            ['label' => 'Kelola Mahasiswa', 'route' => 'dashboard.akademik.mahasiswas', 'icon' => 'fa-users', 'badge' => null],
            ['label' => 'Kelola Tagihan', 'route' => 'dashboard.akademik.tagihan', 'icon' => 'fa-file-invoice', 'badge' => null],
        ],
        'pimpinan' => [
            ['label' => 'Dashboard', 'route' => 'dashboard.pimpinan', 'icon' => 'fa-home', 'badge' => null],
            ['label' => 'Laporan', 'route' => 'dashboard.pimpinan.laporan', 'icon' => 'fa-chart-bar', 'badge' => null],
            ['label' => 'Rekap Tagihan', 'route' => 'dashboard.pimpinan.rekap-tagihan', 'icon' => 'fa-file-invoice', 'badge' => null],
            ['label' => 'Monitoring', 'route' => 'dashboard.pimpinan.monitoring', 'icon' => 'fa-eye', 'badge' => null],
        ],
        default => []
    };

    $roleDisplay = match($user->role) {
        'mahasiswa' => 'Mahasiswa',
        'admin_keuangan' => 'Admin Keuangan',
        'admin' => 'Admin Keuangan',
        'akademik' => 'Bagian Akademik',
        'pimpinan' => 'Pimpinan',
        default => 'User'
    };
@endphp

<div id="sidebarMobile" class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transform overflow-y-auto bg-white border-r border-slate-200 shadow-lg transition-transform duration-300 lg:hidden">
    <div class="flex items-center justify-between gap-3 px-4 py-5 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-3xl bg-sky-600 flex items-center justify-center text-white text-lg shadow-sm">
                <i class="fas fa-university"></i>
            </div>
            <div>
                <p class="text-lg font-semibold text-slate-900">SIPATU</p>
                <p class="text-xs text-slate-500">Pembayaran Mahasiswa</p>
            </div>
        </div>
        <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-100" onclick="closeSidebar()" aria-label="Close sidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="px-2 py-4 space-y-1">
        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']);
            @endphp
            <a href="{{ route($item['route']) }}"
                class="group flex items-center gap-3 rounded-3xl px-3 py-3 transition duration-200 ease-in-out {{ $isActive ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-sky-700' }}"
            >
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $isActive ? 'bg-sky-100 text-sky-600' : 'bg-slate-100 text-slate-500 group-hover:bg-sky-100 group-hover:text-sky-600' }}">
                    <i class="fas {{ $item['icon'] }}"></i>
                </span>
                <span class="text-sm font-medium">{{ $item['label'] }}</span>
                @if ($item['badge'])
                    <span class="ml-auto rounded-full bg-red-500 px-2 py-0.5 text-[11px] font-semibold text-white">{{ $item['badge'] }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-100 px-4 py-4">
        <div class="flex items-center gap-3 rounded-3xl bg-slate-50 px-3 py-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-sky-600">
                <i class="fas fa-user"></i>
            </div>
            <div class="min-w-0 overflow-hidden">
                <span class="block truncate text-sm font-semibold text-slate-900">{{ $user->name }}</span>
                <span class="block truncate text-xs text-slate-500">{{ $roleDisplay }}</span>
            </div>
        </div>

        <div class="mt-4">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="group flex w-full items-center gap-3 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition-colors hover:bg-red-100">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<aside id="sidebarDesktop" class="hidden lg:flex fixed inset-y-0 left-0 h-screen w-64 bg-white border-r border-slate-200 shadow-sm z-50 flex-col">
    <div class="flex items-center justify-center lg:justify-start gap-3 px-3 py-5 border-b border-slate-100">
        <div class="w-11 h-11 rounded-3xl bg-sky-600 flex items-center justify-center text-white text-lg shadow-sm">
            <i class="fas fa-university"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-lg font-semibold text-slate-900">SIPATU</span>
            <span class="text-xs text-slate-500">Pembayaran Mahasiswa</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']);
            @endphp
            <a href="{{ route($item['route']) }}"
                class="group flex items-center gap-3 rounded-3xl px-3 py-3 transition duration-200 ease-in-out {{ $isActive ? 'bg-sky-50 text-sky-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-sky-700' }}"
            >
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $isActive ? 'bg-sky-100 text-sky-600' : 'bg-slate-100 text-slate-500 group-hover:bg-sky-100 group-hover:text-sky-600' }}">
                    <i class="fas {{ $item['icon'] }}"></i>
                </span>
                <span class="text-sm font-medium">{{ $item['label'] }}</span>
                @if ($item['badge'])
                    <span class="ml-auto rounded-full bg-red-500 px-2 py-0.5 text-[11px] font-semibold text-white">{{ $item['badge'] }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-100 px-3 py-4">
        <div class="flex items-center gap-3 rounded-3xl bg-slate-50 px-3 py-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-sky-600">
                <i class="fas fa-user"></i>
            </div>
            <div class="min-w-0 overflow-hidden">
                <span class="block truncate text-sm font-semibold text-slate-900">{{ $user->name }}</span>
                <span class="block truncate text-xs text-slate-500">{{ $roleDisplay }}</span>
            </div>
        </div>

        <div class="mt-4">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="group flex items-center gap-3 w-full p-2 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200" title="Logout">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 group-hover:bg-red-100 group-hover:text-red-600">
                        <i class="fas fa-sign-out-alt"></i>
                    </span>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
