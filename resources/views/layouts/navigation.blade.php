{{-- ============================================================================
    SIDEBAR — Premium glassmorphism sidebar with RTL support
    Shared Alpine scope from app.blade.php: sidebarOpen, darkMode, closeSidebarOnMobile
    RTL: Tailwind 'rtl:' variant + CSS logical properties (start/end)
============================================================================= --}}

{{-- Mobile backdrop overlay --}}
<div
    x-show="sidebarOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-20 lg:hidden"
    style="display: none;"
    aria-hidden="true"
>
    <div class="absolute inset-0 bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm"></div>
</div>

{{-- Sidebar panel --}}
<aside
    id="sidebar"
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full rtl:translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-250 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full rtl:translate-x-full"
    class="fixed lg:sticky inset-y-0 start-0 z-30
           w-64 shrink-0 flex flex-col
           h-screen top-0
           bg-white dark:bg-slate-900
           border-e border-gray-200/70 dark:border-slate-700/60
           shadow-[4px_0_32px_rgba(0,0,0,0.04)] dark:shadow-[4px_0_32px_rgba(0,0,0,0.35)]
           lg:shadow-none
           overflow-hidden
           theme-transition"
    aria-label="Sidebar navigation"
    style="display: none;"
>

    {{-- ── Sidebar Header / Logo ────────────────────────────────────────── --}}
    <div class="flex items-center justify-between px-5 h-16 shrink-0
                border-b border-gray-200/70 dark:border-slate-700/60
                bg-white dark:bg-slate-900 theme-transition">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-2.5 group focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 rounded-lg"
           @click="closeSidebarOnMobile()">

            {{-- Animated logo mark --}}
            <div class="relative w-8 h-8 rounded-xl
                        bg-gradient-to-br from-indigo-500 to-violet-600
                        dark:from-indigo-400 dark:to-violet-500
                        flex items-center justify-center
                        shadow-sm shadow-indigo-500/30 dark:shadow-indigo-400/20
                        group-hover:scale-105 group-hover:shadow-indigo-500/40
                        transition-all duration-300 shrink-0">
                <x-application-logo class="w-4 h-4 fill-current text-white" />
                {{-- Subtle glow ring --}}
                <div class="absolute inset-0 rounded-xl ring-2 ring-inset ring-white/20 dark:ring-white/10"></div>
            </div>

            <div class="flex flex-col leading-none">
                <span class="text-base font-bold text-gray-900 dark:text-white tracking-tight
                             group-hover:text-indigo-600 dark:group-hover:text-indigo-400
                             transition-colors duration-200">
                    {{ __('app.app_name') }}
                </span>
                <span class="text-[10px] font-medium text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                    Backoffice
                </span>
            </div>
        </a>

        {{-- Close button (mobile only) --}}
        <button
            @click="sidebarOpen = false"
            class="lg:hidden inline-flex items-center justify-center w-7 h-7 rounded-lg
                   text-gray-400 dark:text-slate-500
                   hover:text-gray-600 dark:hover:text-slate-300
                   hover:bg-gray-100 dark:hover:bg-slate-800
                   transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            aria-label="Close sidebar"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- ── Navigation Links ─────────────────────────────────────────────── --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-5 px-3 no-scrollbar">

        {{-- Section: Main --}}
        <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-[0.1em]">
            {{ __('Dashboard') }}
        </p>
        <ul class="space-y-0.5 mb-6">
            <x-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
                icon="chart-bar"
                @click="closeSidebarOnMobile()">
                {{ __('app.dashboard') }}
            </x-nav-link>
        </ul>

        {{-- Section: Job Management --}}
        <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-[0.1em]">
            {{ __('Jobs') }}
        </p>
        <ul class="space-y-0.5 mb-6">
            <x-nav-link
                :href="route('job-vacancy.index')"
                :active="request()->routeIs('job-vacancy.*')"
                icon="briefcase"
                @click="closeSidebarOnMobile()">
                {{ __('app.job_vacancies') }}
            </x-nav-link>

            <x-nav-link
                :href="route('job-application.index')"
                :active="request()->routeIs('job-application.*')"
                icon="document-text"
                @click="closeSidebarOnMobile()">
                {{ __('app.applications') }}
            </x-nav-link>

            @if (auth()->user()->role === 'admin')
                <x-nav-link
                    :href="route('job-category.index')"
                    :active="request()->routeIs('job-category.*')"
                    icon="tag"
                    @click="closeSidebarOnMobile()">
                    {{ __('app.categories') }}
                </x-nav-link>
            @endif
        </ul>

        {{-- Section: Companies (admin only) --}}
        @if (auth()->user()->role === 'admin')
            <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-[0.1em]">
                {{ __('Management') }}
            </p>
            <ul class="space-y-0.5 mb-6">
                <x-nav-link
                    :href="route('company.index')"
                    :active="request()->routeIs('company.*')"
                    icon="building-office"
                    @click="closeSidebarOnMobile()">
                    {{ __('app.companies') }}
                </x-nav-link>

                <x-nav-link
                    :href="route('user.index')"
                    :active="request()->routeIs('user.*')"
                    icon="users"
                    @click="closeSidebarOnMobile()">
                    {{ __('app.users') }}
                </x-nav-link>
            </ul>
        @endif

        {{-- Section: My Company (company role only) --}}
        @if (auth()->user()->role === 'company')
            <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-[0.1em]">
                {{ __('My Account') }}
            </p>
            <ul class="space-y-0.5 mb-6">
                <x-nav-link
                    :href="route('my-company.show')"
                    :active="request()->routeIs('my-company.*')"
                    icon="building-office"
                    @click="closeSidebarOnMobile()">
                    {{ __('app.my_company') }}
                </x-nav-link>
            </ul>
        @endif

    </nav>

    {{-- ── Sidebar Footer ────────────────────────────────────────────────── --}}
    <div class="shrink-0 px-3 pb-4 pt-3 border-t border-gray-200/70 dark:border-slate-700/60 bg-white dark:bg-slate-900 theme-transition">

        {{-- User profile mini-card --}}
        <a href="{{ route('profile.edit') }}"
           @click="closeSidebarOnMobile()"
           class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl
                  hover:bg-gray-50 dark:hover:bg-slate-800
                  border border-transparent hover:border-gray-200/60 dark:hover:border-slate-700
                  transition-all duration-200 group focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">

            {{-- Avatar --}}
            <div class="w-8 h-8 rounded-full shrink-0
                        bg-gradient-to-br from-indigo-500 to-violet-600 dark:from-indigo-400 dark:to-violet-500
                        flex items-center justify-center
                        text-white text-xs font-bold
                        shadow-sm ring-2 ring-white dark:ring-slate-900">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate leading-tight
                          group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-400 dark:text-slate-500 capitalize leading-tight">
                    {{ auth()->user()->role }}
                </p>
            </div>

            <svg class="w-4 h-4 text-gray-300 dark:text-slate-600 group-hover:text-indigo-400 transition-colors shrink-0 rtl:rotate-180"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium
                           text-red-500 dark:text-red-400
                           hover:bg-red-50 dark:hover:bg-red-500/10
                           hover:text-red-600 dark:hover:text-red-300
                           border border-transparent hover:border-red-100 dark:hover:border-red-500/20
                           transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                {{ __('app.logout') }}
            </button>
        </form>

    </div>
</aside>
