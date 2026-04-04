@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'group relative flex items-center px-4 py-3.5 w-full text-sm font-bold text-indigo-700 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-300 rounded-2xl shadow-sm border border-indigo-100/50 dark:border-indigo-500/20 overflow-hidden transition-all duration-300 hover:shadow-md'
            : 'group relative flex items-center px-4 py-3.5 w-full text-sm font-medium text-gray-500 dark:text-gray-400 border border-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:border-gray-200 dark:hover:border-gray-700 rounded-2xl transition-all duration-300 transform hover:translate-x-1';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if($active ?? false)
            <!-- Glowing line marker -->
            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-gradient-to-b from-indigo-500 to-blue-500 rounded-r-md shadow-[0_0_8px_rgba(99,102,241,0.8)]"></div>
        @endif
        <div class="px-1.5 flex items-center w-full">
            {{ $slot }}
        </div>
    </a>
</li>
