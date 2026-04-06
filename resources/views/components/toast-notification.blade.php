{{--
    Toast Notification Component
    Displays session flash messages (success, error, warning) as a beautiful
    floating toast in the bottom-end corner with auto-dismiss and manual close.
    Supports RTL via logical CSS end-0 placement.
--}}
<div
    class="fixed bottom-5 end-5 z-50 flex flex-col gap-2.5 pointer-events-none"
    aria-live="polite"
    aria-atomic="true"
>
    @foreach([
        'success' => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'border' => 'border-emerald-200 dark:border-emerald-500/30', 'text' => 'text-emerald-800 dark:text-emerald-300', 'icon_color' => 'text-emerald-500 dark:text-emerald-400', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
        'error'   => ['bg' => 'bg-red-50 dark:bg-red-900/20',     'border' => 'border-red-200 dark:border-red-500/30',     'text' => 'text-red-800 dark:text-red-300',     'icon_color' => 'text-red-500 dark:text-red-400',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>'],
        'warning' => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-200 dark:border-amber-500/30', 'text' => 'text-amber-800 dark:text-amber-300', 'icon_color' => 'text-amber-500 dark:text-amber-400', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>'],
        'info'    => ['bg' => 'bg-sky-50 dark:bg-sky-900/20',     'border' => 'border-sky-200 dark:border-sky-500/30',     'text' => 'text-sky-800 dark:text-sky-300',     'icon_color' => 'text-sky-500 dark:text-sky-400',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>'],
    ] as $type => $cfg)
        @if(session($type))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                class="pointer-events-auto flex items-start gap-3
                       min-w-[300px] max-w-sm w-full px-4 py-3.5 rounded-2xl
                       {{ $cfg['bg'] }} {{ $cfg['border'] }}
                       border shadow-[0_8px_32px_-4px_rgba(0,0,0,0.15)]
                       dark:shadow-[0_8px_32px_-4px_rgba(0,0,0,0.50)]"
                role="alert"
                style="display: none;"
            >
                {{-- Icon --}}
                <svg class="w-5 h-5 mt-0.5 shrink-0 {{ $cfg['icon_color'] }}"
                     fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    {!! $cfg['icon'] !!}
                </svg>

                {{-- Message --}}
                <p class="flex-1 text-sm font-medium {{ $cfg['text'] }}">
                    {{ session($type) }}
                </p>

                {{-- Close button --}}
                <button
                    @click="show = false"
                    class="shrink-0 rounded-lg p-1 -me-1 -mt-0.5
                           {{ $cfg['icon_color'] }} opacity-60 hover:opacity-100
                           hover:bg-black/5 dark:hover:bg-white/10
                           transition-all duration-150 focus:outline-none"
                    aria-label="Dismiss"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Auto-dismiss progress bar --}}
                <div class="absolute bottom-0 start-0 end-0 h-0.5 rounded-b-2xl overflow-hidden">
                    <div class="h-full {{ $type === 'success' ? 'bg-emerald-400' : ($type === 'error' ? 'bg-red-400' : ($type === 'warning' ? 'bg-amber-400' : 'bg-sky-400')) }}
                                animate-[shrink_5s_linear_forwards]"></div>
                </div>
            </div>
        @endif
    @endforeach
</div>

@once
    @push('styles')
    <style>
        @keyframes shrink {
            from { width: 100%; }
            to   { width: 0%; }
        }
    </style>
    @endpush
@endonce
