<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ in_array(app()->getLocale(), ['ar']) ? 'rtl' : 'ltr' }}"
      class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($title){{ $title }} — @endisset{{ config('app.name', 'Shaghalni') }}</title>
    <meta name="description" content="{{ $description ?? __('app.app_name') . ' — Job Backoffice Management System' }}">

    {{-- Preconnect for fonts (both Bunny and Google fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Anti-FOUC: apply persisted theme instantly before paint --}}
    <script>
        (function () {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

{{--
    Root Alpine scope — all child components share these reactive properties:
      sidebarOpen : controls sidebar visibility
      darkMode    : mirrors the <html> dark class
      userMenuOpen: controls the user avatar dropdown
      langMenuOpen: controls the language switcher dropdown
--}}
<body
    class="h-full font-sans antialiased bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100 theme-transition"
    x-data="{
        sidebarOpen: window.matchMedia('(min-width: 1024px)').matches,
        darkMode: document.documentElement.classList.contains('dark'),
        userMenuOpen: false,
        langMenuOpen: false,

        toggleTheme() {
            this.darkMode = !this.darkMode;
            document.documentElement.classList.toggle('dark', this.darkMode);
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        },

        closeSidebarOnMobile() {
            if (window.innerWidth < 1024) {
                this.sidebarOpen = false;
            }
        }
    }"
    @resize.window="sidebarOpen = window.innerWidth >= 1024"
    @keydown.escape.window="userMenuOpen = false; langMenuOpen = false;"
>

    <div class="flex h-full">

        {{-- ================================================================
            SIDEBAR
        ================================================================= --}}
        @include('layouts.navigation')

        {{-- ================================================================
            MAIN CONTENT AREA
        ================================================================= --}}
        <div class="flex flex-col flex-1 min-w-0 min-h-screen overflow-hidden">

            {{-- ============================================================
                TOP NAVIGATION BAR
            ============================================================= --}}
            <header class="sticky top-0 z-20 shrink-0
                           bg-white/80 dark:bg-slate-900/80
                           backdrop-blur-xl
                           border-b border-gray-200/60 dark:border-slate-700/50
                           shadow-[0_1px_0_0_rgba(0,0,0,0.04)]
                           dark:shadow-[0_1px_0_0_rgba(0,0,0,0.3)]
                           theme-transition">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6">

                    {{-- Left cluster: hamburger + breadcrumb/page title --}}
                    <div class="flex items-center gap-3 min-w-0">

                        {{-- Sidebar hamburger toggle --}}
                        <button
                            @click="sidebarOpen = !sidebarOpen"
                            id="sidebar-toggle"
                            aria-label="Toggle sidebar"
                            class="flex-shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-xl
                                   text-gray-500 dark:text-gray-400
                                   hover:text-indigo-600 dark:hover:text-indigo-400
                                   hover:bg-indigo-50 dark:hover:bg-indigo-500/10
                                   border border-transparent hover:border-indigo-100 dark:hover:border-indigo-500/20
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                   transition-all duration-200"
                        >
                            {{-- Three-line burger, morphs to X --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path x-show="!sidebarOpen" x-transition.opacity stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="sidebarOpen" x-transition.opacity stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- Page heading slot --}}
                        @isset($header)
                            <div class="min-w-0 truncate">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    {{-- Right cluster: lang + theme + user --}}
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">

                        {{-- ── Language Switcher ────────────────────────────── --}}
                        <div class="relative" x-data @click.outside="langMenuOpen = false">
                            <button
                                @click="langMenuOpen = !langMenuOpen"
                                id="lang-menu-btn"
                                aria-haspopup="true"
                                :aria-expanded="langMenuOpen"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl
                                       text-xs font-semibold
                                       text-gray-600 dark:text-gray-300
                                       bg-gray-100 dark:bg-slate-800
                                       hover:bg-gray-200 dark:hover:bg-slate-700
                                       border border-gray-200/60 dark:border-slate-700
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                       transition-all duration-200"
                            >
                                {{-- Globe icon --}}
                                <svg class="w-4 h-4 text-indigo-500 dark:text-indigo-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3.284 14.253A8.959 8.959 0 013 12c0-1.016.132-2.002.381-2.938" />
                                </svg>
                                <span class="hidden sm:inline">
                                    {{ app()->getLocale() === 'ar' ? 'ع' : 'EN' }}
                                </span>
                                <svg class="w-3 h-3 transition-transform duration-200" :class="langMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Language dropdown --}}
                            <div
                                x-show="langMenuOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                class="absolute end-0 mt-2 w-44 rounded-2xl
                                       bg-white dark:bg-slate-800
                                       border border-gray-100 dark:border-slate-700
                                       shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_32px_-4px_rgba(0,0,0,0.5)]
                                       overflow-hidden z-50 origin-top-end"
                                style="display: none;"
                                role="menu"
                            >
                                <div class="p-1.5 space-y-0.5">
                                    {{-- English --}}
                                    <a href="{{ route('locale.switch', 'en') }}"
                                       role="menuitem"
                                       @click="langMenuOpen = false"
                                       class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                                              transition-colors duration-150
                                              {{ app()->getLocale() === 'en'
                                                  ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-300'
                                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700/60' }}">
                                        <span class="text-base leading-none">🇬🇧</span>
                                        <span>English</span>
                                        @if(app()->getLocale() === 'en')
                                            <svg class="w-3.5 h-3.5 ms-auto text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </a>
                                    {{-- Arabic --}}
                                    <a href="{{ route('locale.switch', 'ar') }}"
                                       role="menuitem"
                                       @click="langMenuOpen = false"
                                       class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                                              transition-colors duration-150
                                              {{ app()->getLocale() === 'ar'
                                                  ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-300'
                                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700/60' }}">
                                        <span class="text-base leading-none">🇸🇦</span>
                                        <span>العربية</span>
                                        @if(app()->getLocale() === 'ar')
                                            <svg class="w-3.5 h-3.5 ms-auto text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- ── Theme Toggle ─────────────────────────────────── --}}
                        <button
                            @click="toggleTheme()"
                            id="theme-toggle"
                            :aria-label="darkMode ? '{{ __('app.light_mode') }}' : '{{ __('app.dark_mode') }}'"
                            class="relative w-9 h-9 inline-flex items-center justify-center rounded-xl
                                   text-gray-500 dark:text-gray-400
                                   bg-gray-100 dark:bg-slate-800
                                   hover:bg-amber-50 dark:hover:bg-indigo-500/10
                                   hover:text-amber-500 dark:hover:text-indigo-400
                                   border border-gray-200/60 dark:border-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                   transition-all duration-200 group"
                        >
                            {{-- Sun (light mode icon) --}}
                            <svg x-show="!darkMode" x-transition.opacity.duration.200ms
                                class="w-4.5 h-4.5 group-hover:rotate-45 transition-transform duration-300"
                                style="display:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            {{-- Moon (dark mode icon) --}}
                            <svg x-show="darkMode" x-transition.opacity.duration.200ms
                                class="w-4.5 h-4.5 group-hover:-rotate-12 transition-transform duration-300"
                                style="display:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                        </button>

                        {{-- ── User Menu ────────────────────────────────────── --}}
                        <div class="relative" x-data @click.outside="userMenuOpen = false">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                id="user-menu-btn"
                                aria-haspopup="true"
                                :aria-expanded="userMenuOpen"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-xl
                                       hover:bg-gray-100 dark:hover:bg-slate-800
                                       border border-transparent hover:border-gray-200/60 dark:hover:border-slate-700
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/40
                                       transition-all duration-200 group"
                            >
                                {{-- Avatar circle with initials --}}
                                <span class="relative inline-flex w-7 h-7 rounded-full shrink-0
                                             bg-gradient-to-br from-indigo-500 to-violet-600
                                             dark:from-indigo-400 dark:to-violet-500
                                             items-center justify-center
                                             text-white text-xs font-bold
                                             shadow-sm ring-2 ring-white dark:ring-slate-900
                                             transition-all duration-200 group-hover:ring-indigo-200 dark:group-hover:ring-indigo-800">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-200 max-w-[120px] truncate">
                                    {{ auth()->user()->name }}
                                </span>
                                <svg class="hidden md:block w-3.5 h-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                                    :class="userMenuOpen ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- User dropdown --}}
                            <div
                                x-show="userMenuOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                class="absolute end-0 mt-2 w-60 rounded-2xl
                                       bg-white dark:bg-slate-800
                                       border border-gray-100 dark:border-slate-700
                                       shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_32px_-4px_rgba(0,0,0,0.5)]
                                       overflow-hidden z-50 origin-top-end"
                                style="display: none;"
                                role="menu"
                            >
                                {{-- User info header --}}
                                <div class="px-4 py-3.5 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-br from-indigo-50/60 to-violet-50/40 dark:from-indigo-500/5 dark:to-violet-500/5">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('app.profile') }}</p>
                                    <p class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                {{-- Menu items --}}
                                <div class="p-1.5">
                                    <a href="{{ route('profile.edit') }}"
                                       role="menuitem"
                                       @click="userMenuOpen = false"
                                       class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                                              text-gray-700 dark:text-gray-200
                                              hover:bg-indigo-50 dark:hover:bg-indigo-500/10
                                              hover:text-indigo-700 dark:hover:text-indigo-300
                                              transition-colors duration-150 group">
                                        <svg class="w-4 h-4 shrink-0 text-gray-400 dark:text-gray-500 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        {{ __('app.profile') }}
                                    </a>

                                    <div class="my-1 h-px bg-gray-100 dark:bg-slate-700"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                role="menuitem"
                                                class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                                                       text-red-600 dark:text-red-400
                                                       hover:bg-red-50 dark:hover:bg-red-500/10
                                                       transition-colors duration-150 group">
                                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                            </svg>
                                            {{ __('app.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /right cluster --}}
                </div>
            </header>

            {{-- ============================================================
                PAGE CONTENT
            ============================================================= --}}
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>

        </div>{{-- /main content area --}}

    </div>{{-- /flex root --}}

</body>
</html>
