@props(['active' => false, 'icon' => null])

@php
    $isActive = $active ?? false;

    $baseClasses = 'relative flex items-center gap-3 px-3 py-2.5 w-full text-sm rounded-xl
                    border transition-all duration-200 focus:outline-none
                    focus-visible:ring-2 focus-visible:ring-indigo-500/40';

    $activeClasses = 'font-semibold text-indigo-700 dark:text-indigo-300
                      bg-indigo-50 dark:bg-indigo-500/10
                      border-indigo-100/70 dark:border-indigo-500/25
                      shadow-sm';

    $inactiveClasses = 'font-medium text-gray-600 dark:text-gray-400
                        border-transparent
                        hover:text-gray-900 dark:hover:text-gray-100
                        hover:bg-gray-100/70 dark:hover:bg-slate-800/70
                        hover:border-gray-200/60 dark:hover:border-slate-700';

    $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);

    /*
     * Icon SVG paths — keyed by identifier string.
     * Using Heroicons 2.x outline set (24x24 stroke-based).
     */
    $icons = [
        'chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />',

        'briefcase' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />',

        'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',

        'tag' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />',

        'building-office' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />',

        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
    ];

    $iconPath = isset($icons[$icon]) ? $icons[$icon] : null;
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>

        {{-- Active indicator bar — LTR: left | RTL: right (via logical CSS start) --}}
        @if($isActive)
            <span class="absolute start-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-e-full
                         bg-gradient-to-b from-indigo-500 to-violet-500
                         shadow-[0_0_8px_rgba(99,102,241,0.6)]"
                  aria-hidden="true"></span>
        @endif

        {{-- Icon --}}
        @if($iconPath)
            <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-gray-600 dark:group-hover:text-slate-300' }} transition-colors duration-200"
                 fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"
                 aria-hidden="true">
                {!! $iconPath !!}
            </svg>
        @endif

        {{-- Label --}}
        <span class="leading-none">{{ $slot }}</span>

    </a>
</li>
