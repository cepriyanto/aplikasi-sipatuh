<!-- components/card-statistik.blade.php -->
@props([
    'title' => '',
    'value' => '',
    'subtitle' => '',
    'icon' => 'fa-chart-line',
    'color' => 'blue'
])

@php
$colorClasses = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'orange' => 'bg-orange-100 text-orange-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'red' => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'indigo' => 'bg-indigo-100 text-indigo-600',
    'pink' => 'bg-pink-100 text-pink-600',
];

$iconBgClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm text-gray-500 mb-1">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
            @if($subtitle)
                <p class="text-sm text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="w-12 h-12 {{ $iconBgClass }} rounded-lg flex items-center justify-center">
            <i class="fas {{ $icon }} text-xl"></i>
        </div>
    </div>
</div>