<!-- components/pengumuman.blade.php -->
@props([
    'title' => 'Pengumuman',
    'desc' => '',
    'deadline' => '',
    'color' => 'blue'
])

@php
$colorClasses = [
    'blue' => 'bg-blue-50 border-blue-500 text-blue-700',
    'red' => 'bg-red-50 border-red-500 text-red-700',
    'green' => 'bg-green-50 border-green-500 text-green-700',
    'orange' => 'bg-orange-50 border-orange-500 text-orange-700',
    'purple' => 'bg-purple-50 border-purple-500 text-purple-700',
    'indigo' => 'bg-indigo-50 border-indigo-500 text-indigo-700',
];

$bgClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @if($desc)
    <div class="p-4 rounded-lg border-l-4 {{ $bgClass }}">
        <p class="text-gray-700">{{ $desc }}</p>
        @if($deadline)
        <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
            <i class="fas fa-clock"></i>
            <span>{{ $deadline }}</span>
        </div>
        @endif
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <i class="fas fa-bullhorn text-4xl mb-3 text-gray-300"></i>
        <p>Tidak ada pengumuman</p>
    </div>
    @endif
</div>