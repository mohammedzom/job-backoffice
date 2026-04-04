<!-- Mobile overlay backdrop -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-gray-900/80 lg:hidden" @click="sidebarOpen = false"
    style="display: none;"></div>

<!-- Sidebar Component -->
<nav x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed lg:sticky inset-y-0 left-0 z-30 w-[250px] bg-white dark:bg-gray-800/90 dark:backdrop-blur-xl h-screen top-0 overflow-y-auto border-r border-gray-200 dark:border-gray-700/50 shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] dark:shadow-[4px_0_24px_rgba(0,0,0,0.2)] lg:shadow-none transition-colors duration-300"
    style="display: none;">
    <!-- Logo Section -->
    <div
        class="flex items-center px-6 border-b border-gray-200 dark:border-gray-700/50 py-4 transition-colors duration-300">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
            <x-application-logo
                class="h-6 w-auto fill-current text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300" />
            <span class="text-lg font-bold text-gray-900 dark:text-white tracking-tight"> {{ __('Shaghalni') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6 space-y-2.5">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.*')">
            {{ __('Companies') }}
        </x-nav-link>

        <x-nav-link :href="route('application.index')" :active="request()->routeIs('application.*')">
            {{ __('Applications') }}
        </x-nav-link>

        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.*')">
            {{ __('Categories') }}
        </x-nav-link>

        <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.*')">
            {{ __('Job Vacancies') }}
        </x-nav-link>

        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">
            {{ __('Users') }}
        </x-nav-link>
        <hr />
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <x-nav-link class="text-red-500 dark:text-red-400" :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </ul>
</nav>
