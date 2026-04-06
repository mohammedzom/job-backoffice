{{--
    Data Table Toolbar Component
    Provides search input, filter slots, status toggle (active/archived), and add button.

    Props:
      $searchRoute    — current route name used to build search/filter URL
      $addRoute       — route for the "Add New" button (null to hide)
      $addLabel       — button label
      $isArchived     — bool: whether showing archived
      $archiveRoute   — route with archived=true param
      $activeRoute    — route without archived param
      $totalCount     — optional: number to show near title
--}}
@props([
    'searchRoute'  => null,
    'addRoute'     => null,
    'addLabel'     => 'Add New',
    'isArchived'   => false,
    'archiveRoute' => null,
    'activeRoute'  => null,
    'searchValue'  => '',
    'placeholder'  => 'Search...',
])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-gray-100 dark:border-slate-700/60">

    {{-- Search --}}
    <div class="relative flex-1 max-w-sm">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>
        <form method="GET" action="{{ $searchRoute ?? '#' }}" id="search-form">
            {{-- Re-pass existing query params except 'search' --}}
            @foreach(request()->except(['search', 'page']) as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <input
                type="search"
                name="search"
                id="table-search"
                value="{{ $searchValue }}"
                placeholder="{{ $placeholder }}"
                class="block w-full ps-10 pe-4 py-2.5 text-sm
                       bg-gray-50 dark:bg-slate-800/80
                       border border-gray-200 dark:border-slate-700
                       text-gray-900 dark:text-gray-100
                       placeholder-gray-400 dark:placeholder-slate-500
                       rounded-xl
                       focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                       dark:focus:border-indigo-400
                       transition-all duration-200 outline-none"
                x-on:keydown.enter.prevent="$el.form.submit()"
            >
        </form>
    </div>

    {{-- Right cluster: archive toggle + extra filters slot + add button --}}
    <div class="flex items-center gap-2 flex-shrink-0">

        {{-- Extra filter slot --}}
        {{ $filters ?? '' }}

        {{-- Archive / Active toggle --}}
        @if($archiveRoute && $activeRoute)
            @if($isArchived)
                <a href="{{ $activeRoute }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-sm font-medium
                          bg-emerald-50 dark:bg-emerald-500/10
                          text-emerald-700 dark:text-emerald-300
                          border border-emerald-100 dark:border-emerald-500/20
                          hover:bg-emerald-100 dark:hover:bg-emerald-500/20
                          transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('app.active') ?? 'Active' }}</span>
                </a>
            @else
                <a href="{{ $archiveRoute }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-sm font-medium
                          bg-gray-50 dark:bg-slate-800
                          text-gray-600 dark:text-slate-400
                          border border-gray-200 dark:border-slate-700
                          hover:bg-amber-50 dark:hover:bg-amber-500/10
                          hover:text-amber-700 dark:hover:text-amber-400
                          hover:border-amber-100 dark:hover:border-amber-500/20
                          transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('Archived') }}</span>
                </a>
            @endif
        @endif

        {{-- Add button --}}
        @if($addRoute)
            <a href="{{ $addRoute }}"
               class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                      bg-gradient-to-br from-indigo-600 to-violet-600
                      dark:from-indigo-500 dark:to-violet-500
                      text-white shadow-sm
                      hover:from-indigo-500 hover:to-violet-500
                      hover:shadow-indigo-500/25 hover:shadow-md
                      focus:outline-none focus:ring-2 focus:ring-indigo-500/50
                      transition-all duration-200">
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90"
                     fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span class="hidden sm:inline">{{ $addLabel }}</span>
            </a>
        @endif
    </div>
</div>
