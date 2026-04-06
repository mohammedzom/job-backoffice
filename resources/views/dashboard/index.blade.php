<x-app-layout>
    <x-slot name="title">{{ __('app.dashboard') }}</x-slot>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('app.dashboard') }}
        </h1>
    </x-slot>

    @php
        /* ── helpers ───────────────────────────────────────────────────────── */
        $pending  = $analytics['applicationStatusBreakdown']['pending']  ?? 0;
        $accepted = $analytics['applicationStatusBreakdown']['accepted'] ?? 0;
        $rejected = $analytics['applicationStatusBreakdown']['rejected'] ?? 0;
        $total    = max($analytics['totalApplications'], 1); // guard ÷0

        $isAdmin  = $user->role === 'admin';
        $isRtl    = app()->getLocale() === 'ar';
    @endphp

    {{-- ─────────────────────────────────────────────────────────────────────
        PAGE WRAPPER
    ──────────────────────────────────────────────────────────────────────── --}}
    <div class="p-5 sm:p-6 lg:p-8 space-y-8 animate-fade-in">

        {{-- ══════════════════════════════════════════════════════════════════
             WELCOME BANNER
        ══════════════════════════════════════════════════════════════════════ --}}
        <div class="relative overflow-hidden rounded-3xl
                    bg-gradient-to-br from-indigo-600 via-indigo-500 to-violet-600
                    dark:from-indigo-700 dark:via-indigo-600 dark:to-violet-700
                    px-6 py-7 sm:px-8 sm:py-8
                    shadow-[0_8px_32px_-4px_rgba(99,102,241,0.45)]
                    dark:shadow-[0_8px_32px_-4px_rgba(99,102,241,0.35)]">

            {{-- Decorative blurred circles --}}
            <div class="pointer-events-none absolute -top-10 -end-10 w-52 h-52 rounded-full
                        bg-white/10 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute bottom-0 start-1/4 w-40 h-40 rounded-full
                        bg-violet-400/20 blur-2xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute top-1/2 end-1/3 w-24 h-24 rounded-full
                        bg-indigo-300/10 blur-xl" aria-hidden="true"></div>

            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-indigo-200 text-sm font-medium mb-1">
                        {{ now()->format('l, d M Y') }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white leading-tight">
                        {{ app()->getLocale() === 'ar' ? 'مرحباً بعودتك،' : 'Welcome back,' }}
                        <span class="text-indigo-200">{{ $user->name }}</span> 👋
                    </h2>
                    <p class="mt-1.5 text-indigo-200/80 text-sm">
                        {{ app()->getLocale() === 'ar'
                            ? 'إليك نظرة عامة على لوحة التحكم الخاصة بك.'
                            : "Here's what's happening in your backoffice today." }}
                    </p>
                </div>

                {{-- Role badge --}}
                <div class="shrink-0">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl
                                 bg-white/15 backdrop-blur-sm
                                 border border-white/25
                                 text-white text-sm font-semibold
                                 shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            @if($isAdmin)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            @endif
                        </svg>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             STAT CARDS GRID
        ══════════════════════════════════════════════════════════════════════ --}}
        @php
            $cards = [
                [
                    'show'      => true,
                    'label'     => app()->getLocale() === 'ar' ? 'المستخدمون النشطون' : 'Active Users',
                    'sublabel'  => app()->getLocale() === 'ar' ? 'آخر 30 يوماً' : 'Last 30 days',
                    'value'     => number_format($analytics['activeUsers_last_30_days']),
                    'gradient'  => 'from-sky-500 to-cyan-400',
                    'bg'        => 'bg-sky-50 dark:bg-sky-500/10',
                    'ring'      => 'ring-sky-100 dark:ring-sky-500/20',
                    'text'      => 'text-sky-600 dark:text-sky-400',
                    'icon_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
                    'link'      => $isAdmin ? route('user.index') : null,
                ],
                [
                    'show'      => $isAdmin,
                    'label'     => app()->getLocale() === 'ar' ? 'الشركات' : 'Companies',
                    'sublabel'  => app()->getLocale() === 'ar' ? 'مسجّلة' : 'Registered',
                    'value'     => number_format($analytics['totalCompanies'] ?? 0),
                    'gradient'  => 'from-violet-500 to-purple-400',
                    'bg'        => 'bg-violet-50 dark:bg-violet-500/10',
                    'ring'      => 'ring-violet-100 dark:ring-violet-500/20',
                    'text'      => 'text-violet-600 dark:text-violet-400',
                    'icon_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>',
                    'link'      => route('company.index'),
                ],
                [
                    'show'      => true,
                    'label'     => app()->getLocale() === 'ar' ? 'الوظائف' : 'Job Vacancies',
                    'sublabel'  => app()->getLocale() === 'ar' ? 'إجمالي' : 'Total published',
                    'value'     => number_format($analytics['totalJobs']),
                    'gradient'  => 'from-indigo-500 to-blue-400',
                    'bg'        => 'bg-indigo-50 dark:bg-indigo-500/10',
                    'ring'      => 'ring-indigo-100 dark:ring-indigo-500/20',
                    'text'      => 'text-indigo-600 dark:text-indigo-400',
                    'icon_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>',
                    'link'      => route('job-vacancy.index'),
                ],
                [
                    'show'      => true,
                    'label'     => app()->getLocale() === 'ar' ? 'الطلبات' : 'Applications',
                    'sublabel'  => app()->getLocale() === 'ar' ? 'إجمالي' : 'Total received',
                    'value'     => number_format($analytics['totalApplications']),
                    'gradient'  => 'from-emerald-500 to-teal-400',
                    'bg'        => 'bg-emerald-50 dark:bg-emerald-500/10',
                    'ring'      => 'ring-emerald-100 dark:ring-emerald-500/20',
                    'text'      => 'text-emerald-600 dark:text-emerald-400',
                    'icon_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
                    'link'      => route('job-application.index'),
                ],
                [
                    'show'      => true,
                    'label'     => app()->getLocale() === 'ar' ? 'إجمالي المشاهدات' : 'Total Views',
                    'sublabel'  => app()->getLocale() === 'ar' ? 'مشاهدات الوظائف' : 'Across all jobs',
                    'value'     => number_format($analytics['totalViews']),
                    'gradient'  => 'from-amber-500 to-orange-400',
                    'bg'        => 'bg-amber-50 dark:bg-amber-500/10',
                    'ring'      => 'ring-amber-100 dark:ring-amber-500/20',
                    'text'      => 'text-amber-600 dark:text-amber-400',
                    'icon_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'link'      => null,
                ],
            ];
            $visibleCards = collect($cards)->filter(fn($c) => $c['show']);
            $colClass = $visibleCards->count() >= 5 ? 'sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5' : 'sm:grid-cols-2 lg:grid-cols-4';
        @endphp

        <div class="grid grid-cols-1 {{ $colClass }} gap-4">
            @foreach($visibleCards as $card)
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card hover:shadow-card-md
                        transition-all duration-300
                        overflow-hidden {{ $card['link'] ? 'cursor-pointer' : '' }}"
                 @if($card['link']) onclick="window.location='{{ $card['link'] }}'" @endif>

                {{-- Gradient top accent stripe --}}
                <div class="h-1 w-full bg-gradient-to-r {{ $card['gradient'] }}"></div>

                {{-- Subtle gradient wash on hover --}}
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500
                            bg-gradient-to-br {{ $card['gradient'] }} opacity-[0.03]"
                     aria-hidden="true"></div>

                <div class="relative p-5">
                    {{-- Icon --}}
                    <div class="inline-flex p-2.5 rounded-xl {{ $card['bg'] }} ring-1 {{ $card['ring'] }} mb-4
                                group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 {{ $card['text'] }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            {!! $card['icon_path'] !!}
                        </svg>
                    </div>

                    {{-- Value --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-50 tabular-nums leading-none mb-1
                               group-hover:{{ $card['text'] }} transition-colors duration-300">
                        {{ $card['value'] }}
                    </p>

                    {{-- Label --}}
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300 leading-snug">
                        {{ $card['label'] }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                        {{ $card['sublabel'] }}
                    </p>
                </div>

                {{-- Arrow indicator for clickable cards --}}
                @if($card['link'])
                    <div class="absolute bottom-4 end-4 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-1 group-hover:translate-x-0 rtl:-translate-x-1 rtl:group-hover:translate-x-0">
                        <svg class="w-4 h-4 {{ $card['text'] }} rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             MIDDLE ROW: Application Status Donut Mock + Conversion Table
        ══════════════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Application Status Breakdown ───────────────────────── --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card p-6 flex flex-col gap-5">

                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ app()->getLocale() === 'ar' ? 'حالة الطلبات' : 'Application Status' }}
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'توزيع الطلبات حسب الحالة' : 'Distribution by current status' }}
                        </p>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">
                        {{ number_format($analytics['totalApplications']) }}
                    </span>
                </div>

                {{-- Segmented progress bar --}}
                @php
                    $pendingPct  = $analytics['totalApplications'] > 0 ? round(($pending  / $total) * 100) : 0;
                    $acceptedPct = $analytics['totalApplications'] > 0 ? round(($accepted / $total) * 100) : 0;
                    $rejectedPct = $analytics['totalApplications'] > 0 ? round(($rejected / $total) * 100) : 0;
                @endphp
                <div class="flex h-3 rounded-full overflow-hidden gap-0.5 bg-gray-100 dark:bg-slate-700/50">
                    @if($pendingPct > 0)
                        <div class="bg-amber-400 dark:bg-amber-500 rounded-full transition-all duration-700"
                             style="width: {{ $pendingPct }}%"
                             title="{{ $pendingPct }}% pending"></div>
                    @endif
                    @if($acceptedPct > 0)
                        <div class="bg-emerald-500 dark:bg-emerald-400 rounded-full transition-all duration-700"
                             style="width: {{ $acceptedPct }}%"
                             title="{{ $acceptedPct }}% accepted"></div>
                    @endif
                    @if($rejectedPct > 0)
                        <div class="bg-rose-400 dark:bg-rose-500 rounded-full transition-all duration-700"
                             style="width: {{ $rejectedPct }}%"
                             title="{{ $rejectedPct }}% rejected"></div>
                    @endif
                </div>

                {{-- Legend --}}
                <div class="space-y-3">
                    @foreach([
                        ['label' => app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending',  'count' => $pending,  'pct' => $pendingPct,  'dot' => 'bg-amber-400',   'text' => 'text-amber-600 dark:text-amber-400',   'bg' => 'bg-amber-50 dark:bg-amber-500/10'],
                        ['label' => app()->getLocale() === 'ar' ? 'مقبول'       : 'Accepted', 'count' => $accepted, 'pct' => $acceptedPct, 'dot' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400','bg' => 'bg-emerald-50 dark:bg-emerald-500/10'],
                        ['label' => app()->getLocale() === 'ar' ? 'مرفوض'       : 'Rejected', 'count' => $rejected, 'pct' => $rejectedPct, 'dot' => 'bg-rose-400',    'text' => 'text-rose-600 dark:text-rose-400',     'bg' => 'bg-rose-50 dark:bg-rose-500/10'],
                    ] as $row)
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full {{ $row['dot'] }} shrink-0"></div>
                            <span class="flex-1 text-sm text-gray-600 dark:text-gray-300">{{ $row['label'] }}</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 tabular-nums">{{ $row['count'] }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-lg font-medium {{ $row['text'] }} {{ $row['bg'] }}">
                                {{ $row['pct'] }}%
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Conversion Rate Table ───────────────────────────────── --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card flex flex-col overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700/60">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ app()->getLocale() === 'ar' ? 'معدلات التحويل' : 'Conversion Rates' }}
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'أعلى الوظائف من حيث التحويل' : 'Top jobs by views-to-application rate' }}
                        </p>
                    </div>
                    <a href="{{ route('job-vacancy.index') }}"
                       class="text-xs font-medium text-indigo-600 dark:text-indigo-400
                              hover:text-indigo-700 dark:hover:text-indigo-300
                              transition-colors duration-150 flex items-center gap-1">
                        {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                </div>

                <div class="flex-1 overflow-x-auto">
                    @if($analytics['conversionData']->isEmpty())
                        <div class="flex flex-col items-center justify-center py-14 gap-2 text-gray-400 dark:text-slate-600">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                            <p class="text-sm font-medium">{{ app()->getLocale() === 'ar' ? 'لا توجد بيانات بعد' : 'No data yet' }}</p>
                        </div>
                    @else
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50/80 dark:bg-slate-800/60">
                                    <th class="px-5 py-3 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                        {{ app()->getLocale() === 'ar' ? 'الوظيفة' : 'Job Title' }}
                                    </th>
                                    <th class="px-4 py-3 text-center text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500 whitespace-nowrap">
                                        {{ app()->getLocale() === 'ar' ? 'المشاهدات' : 'Views' }}
                                    </th>
                                    <th class="px-4 py-3 text-center text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500 whitespace-nowrap">
                                        {{ app()->getLocale() === 'ar' ? 'الطلبات' : 'Apps' }}
                                    </th>
                                    <th class="px-5 py-3 text-end text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500 whitespace-nowrap">
                                        {{ app()->getLocale() === 'ar' ? 'التحويل' : 'Rate' }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-slate-700/60">
                                @foreach($analytics['conversionData'] as $job)
                                    @php
                                        $rate = $job->calculated_conversion_rate;
                                        $rateColor = $rate >= 20
                                            ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10'
                                            : ($rate >= 10
                                                ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10'
                                                : 'text-gray-500 dark:text-slate-400 bg-gray-50 dark:bg-slate-700/40');
                                    @endphp
                                    <tr class="hover:bg-gray-50/60 dark:hover:bg-slate-700/20 transition-colors duration-150">
                                        <td class="px-5 py-3.5">
                                            <span class="font-medium text-gray-800 dark:text-gray-200 line-clamp-1">{{ $job->title }}</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-gray-500 dark:text-slate-400 tabular-nums">{{ number_format($job->view_count) }}</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-gray-500 dark:text-slate-400 tabular-nums">{{ number_format($job->apply_count) }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-end">
                                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold tabular-nums {{ $rateColor }}">
                                                {{ $rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             BOTTOM ROW: Most Applied Jobs + Recent Applications
        ══════════════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ── Most Applied Jobs ──────────────────────────────────── --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card flex flex-col overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700/60">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ app()->getLocale() === 'ar' ? 'الوظائف الأكثر طلباً' : 'Most Applied Jobs' }}
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'أعلى 5 وظائف' : 'Top 5 by applications' }}
                        </p>
                    </div>
                </div>

                <div class="flex-1 p-4">
                    @if($analytics['mostAppliedJobs']->isEmpty())
                        <div class="flex flex-col items-center justify-center h-full py-10 gap-2 text-gray-400 dark:text-slate-600">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            <p class="text-sm">{{ app()->getLocale() === 'ar' ? 'لا توجد وظائف' : 'No jobs yet' }}</p>
                        </div>
                    @else
                        @php $maxApply = $analytics['mostAppliedJobs']->max('apply_count') ?: 1; @endphp
                        <ol class="space-y-3">
                            @foreach($analytics['mostAppliedJobs'] as $i => $job)
                                @php
                                    $barWidth = $maxApply > 0 ? round(($job->apply_count / $maxApply) * 100) : 0;
                                    $rankColors = ['bg-amber-400','bg-gray-300 dark:bg-slate-600','bg-orange-300 dark:bg-orange-600'];
                                    $rankColor  = $rankColors[$i] ?? 'bg-gray-200 dark:bg-slate-700';
                                @endphp
                                <li class="group relative">
                                    <div class="flex items-center gap-3 p-3 rounded-xl
                                                hover:bg-gray-50 dark:hover:bg-slate-700/40
                                                transition-colors duration-150">
                                        {{-- Rank badge --}}
                                        <span class="w-6 h-6 rounded-full {{ $rankColor }} flex items-center justify-center
                                                     text-xs font-bold text-white dark:text-gray-900 shrink-0">
                                            {{ $i + 1 }}
                                        </span>

                                        {{-- Job info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate leading-tight">
                                                {{ $job->title }}
                                            </p>
                                            @if($isAdmin && $job->company)
                                                <p class="text-xs text-gray-400 dark:text-slate-500 truncate mt-0.5">
                                                    {{ $job->company->name }}
                                                </p>
                                            @endif

                                            {{-- Mini bar --}}
                                            <div class="mt-1.5 h-1.5 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all duration-700"
                                                     style="width: {{ $barWidth }}%"></div>
                                            </div>
                                        </div>

                                        {{-- Count --}}
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200 tabular-nums shrink-0">
                                            {{ number_format($job->apply_count) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

            {{-- ── Recent Applications Feed ─────────────────────────────── --}}
            <div class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card flex flex-col overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700/60">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ app()->getLocale() === 'ar' ? 'أحدث الطلبات' : 'Recent Applications' }}
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'آخر 6 طلبات تم استلامها' : 'Last 6 applications received' }}
                        </p>
                    </div>
                    <a href="{{ route('job-application.index') }}"
                       class="text-xs font-medium text-indigo-600 dark:text-indigo-400
                              hover:text-indigo-700 dark:hover:text-indigo-300
                              transition-colors duration-150 flex items-center gap-1">
                        {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                </div>

                {{-- Applications feed --}}
                <div class="flex-1 divide-y divide-gray-50 dark:divide-slate-700/40 overflow-y-auto">
                    @forelse($analytics['recentApplications'] as $app)
                        @php
                            $statusMap = [
                                'pending'  => ['label' => app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending',  'classes' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 ring-amber-100 dark:ring-amber-500/20'],
                                'accepted' => ['label' => app()->getLocale() === 'ar' ? 'مقبول'       : 'Accepted', 'classes' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 ring-emerald-100 dark:ring-emerald-500/20'],
                                'rejected' => ['label' => app()->getLocale() === 'ar' ? 'مرفوض'       : 'Rejected', 'classes' => 'bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-300 ring-rose-100 dark:ring-rose-500/20'],
                            ];
                            $st = $statusMap[$app->status] ?? ['label' => ucfirst($app->status), 'classes' => 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 ring-gray-100 dark:ring-slate-600'];
                            $initials = strtoupper(substr($app->user?->name ?? '?', 0, 1));
                            $avatarGradients = [
                                'from-indigo-500 to-violet-600',
                                'from-rose-500 to-pink-600',
                                'from-emerald-500 to-teal-600',
                                'from-amber-500 to-orange-600',
                                'from-sky-500 to-cyan-600',
                                'from-fuchsia-500 to-purple-600',
                            ];
                            $avatarGrad = $avatarGradients[$loop->index % count($avatarGradients)];
                        @endphp
                        <div class="flex items-start gap-4 px-5 py-4
                                    hover:bg-gray-50/60 dark:hover:bg-slate-700/20
                                    transition-colors duration-150">

                            {{-- Avatar --}}
                            <div class="w-9 h-9 rounded-full shrink-0 flex items-center justify-center
                                        bg-gradient-to-br {{ $avatarGrad }}
                                        text-white text-xs font-bold shadow-sm
                                        ring-2 ring-white dark:ring-slate-800">
                                {{ $initials }}
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate leading-tight">
                                            {{ $app->user?->name ?? (app()->getLocale() === 'ar' ? 'مستخدم محذوف' : 'Deleted user') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 truncate mt-0.5">
                                            {{ app()->getLocale() === 'ar' ? 'تقدّم لـ:' : 'Applied to:' }}
                                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                                {{ $app->job?->title ?? '—' }}
                                            </span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-semibold
                                                 ring-1 {{ $st['classes'] }} shrink-0 whitespace-nowrap">
                                        {{ $st['label'] }}
                                    </span>
                                </div>

                                {{-- Timestamp --}}
                                <p class="text-[11px] text-gray-400 dark:text-slate-600 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $app->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-14 gap-2 text-gray-400 dark:text-slate-600">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m0-15.75H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                            <p class="text-sm font-medium">{{ app()->getLocale() === 'ar' ? 'لا توجد طلبات بعد' : 'No applications yet' }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             CHART PLACEHOLDER SECTION
        ══════════════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Jobs Over Time placeholder --}}
            @foreach([
                ['title' => app()->getLocale() === 'ar' ? 'الوظائف المضافة (هذا الشهر)' : 'Jobs Added Over Time',   'subtitle' => app()->getLocale() === 'ar' ? 'رسم بياني قادم' : 'Chart coming soon',   'icon_color' => 'text-indigo-500', 'bar_heights' => [35, 55, 42, 70, 58, 80, 65, 90, 75, 88, 60, 95]],
                ['title' => app()->getLocale() === 'ar' ? 'الطلبات الواردة (هذا الشهر)' : 'Applications Over Time', 'subtitle' => app()->getLocale() === 'ar' ? 'رسم بياني قادم' : 'Chart coming soon', 'icon_color' => 'text-emerald-500', 'bar_heights' => [20, 45, 32, 60, 48, 72, 55, 78, 62, 85, 50, 92]],
            ] as $chart)
            <div class="bg-white dark:bg-slate-800 rounded-2xl
                        border border-gray-100 dark:border-slate-700/60
                        shadow-card overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700/60">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $chart['title'] }}</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">{{ $chart['subtitle'] }}</p>
                    </div>
                    {{-- Month selector badge --}}
                    <span class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-slate-700
                                 text-gray-500 dark:text-slate-400 font-medium">
                        {{ now()->format('M Y') }}
                    </span>
                </div>

                {{-- Decorative mini-bar chart (pure CSS, no JS) --}}
                <div class="px-6 py-5">
                    <div class="flex items-end gap-1.5 h-28">
                        @foreach($chart['bar_heights'] as $idx => $h)
                            @php
                                $isLast = $idx === array_key_last($chart['bar_heights']);
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-md transition-all duration-300 hover:opacity-80
                                           {{ $isLast
                                               ? 'bg-gradient-to-t from-indigo-600 to-indigo-400 dark:from-indigo-500 dark:to-indigo-300'
                                               : 'bg-gray-100 dark:bg-slate-700 hover:bg-indigo-100 dark:hover:bg-indigo-500/20' }}"
                                     style="height: {{ $h }}%"
                                     title="{{ $h }}%">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- X-axis labels --}}
                    <div class="flex gap-1.5 mt-2">
                        @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $month)
                            <div class="flex-1 text-center text-[9px] text-gray-300 dark:text-slate-700 font-medium">
                                {{ substr($month, 0, 1) }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer note --}}
                    <div class="mt-4 flex items-center gap-2 text-xs text-gray-400 dark:text-slate-600">
                        <div class="w-3 h-3 rounded-sm bg-gradient-to-r from-indigo-600 to-indigo-400"></div>
                        <span>{{ app()->getLocale() === 'ar' ? 'سيتم ربط بيانات حقيقية قريباً' : 'Real data integration coming soon' }}</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </div>{{-- /page wrapper --}}

</x-app-layout>
