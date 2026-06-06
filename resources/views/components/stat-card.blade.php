@props(['label', 'value', 'color' => 'blue', 'icon' => null])

@php
    $colorMap = [
        'blue'   => ['bg' => 'bg-blue-50 dark:bg-blue-900/30',   'text' => 'text-blue-600 dark:text-blue-400',   'icon' => 'bg-blue-100 dark:bg-blue-800'],
        'green'  => ['bg' => 'bg-green-50 dark:bg-green-900/30',  'text' => 'text-green-600 dark:text-green-400',  'icon' => 'bg-green-100 dark:bg-green-800'],
        'purple' => ['bg' => 'bg-purple-50 dark:bg-purple-900/30','text' => 'text-purple-600 dark:text-purple-400','icon' => 'bg-purple-100 dark:bg-purple-800'],
        'yellow' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/30','text' => 'text-yellow-600 dark:text-yellow-400','icon' => 'bg-yellow-100 dark:bg-yellow-800'],
        'red'    => ['bg' => 'bg-red-50 dark:bg-red-900/30',      'text' => 'text-red-600 dark:text-red-400',      'icon' => 'bg-red-100 dark:bg-red-800'],
    ];
    $c = $colorMap[$color] ?? $colorMap['blue'];
@endphp

<div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 {{ $c['bg'] }}">
    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $label }}</div>
    <div class="text-3xl font-bold {{ $c['text'] }}">{{ $value }}</div>
</div>
