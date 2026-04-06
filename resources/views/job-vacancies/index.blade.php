<x-app-layout>
    <x-slot name="title">{{ __('app.job_vacancies') }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ __('app.job_vacancies') }}
            </h1>
            @if(request('archived'))
                <span class="text-xs px-2 py-0.5 rounded-lg bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-semibold">
                    {{ __('Archived') }}
                </span>
            @else
                <span class="text-xs px-2 py-0.5 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold">
                    {{ $jobVacancies->total() }} {{ __('total') }}
                </span>
            @endif
        </div>
    </x-slot>

    @php
        $typeMap = [
            'full_time' => ['label' => 'Full Time',  'classes' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300 ring-blue-100 dark:ring-blue-500/20'],
            'part_time' => ['label' => 'Part Time',  'classes' => 'bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-300 ring-purple-100 dark:ring-purple-500/20'],
            'contract'  => ['label' => 'Contract',   'classes' => 'bg-pink-50 dark:bg-pink-500/10 text-pink-700 dark:text-pink-300 ring-pink-100 dark:ring-pink-500/20'],
            'remote'    => ['label' => 'Remote',     'classes' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 ring-emerald-100 dark:ring-emerald-500/20'],
            'hybrid'    => ['label' => 'Hybrid',     'classes' => 'bg-cyan-50 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-300 ring-cyan-100 dark:ring-cyan-500/20'],
        ];
        $statusMap = [
            'open'   => ['label' => 'Open',   'classes' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 ring-emerald-100 dark:ring-emerald-500/20'],
            'closed' => ['label' => 'Closed', 'classes' => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-300 ring-red-100 dark:ring-red-500/20'],
            'pending'=> ['label' => 'Pending','classes' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 ring-amber-100 dark:ring-amber-500/20'],
        ];
    @endphp

    <div class="p-5 sm:p-6 lg:p-8 space-y-6 animate-fade-in">

        <x-toast-notification />

        {{-- Data table card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl
                    border border-gray-100 dark:border-slate-700/60
                    shadow-card overflow-hidden">

            {{-- Toolbar with type filter slot --}}
            <x-table-toolbar
                :searchRoute="route('job-vacancy.index', request()->except(['search', 'page']))"
                :addRoute="route('job-vacancy.create')"
                :addLabel="__('Add Job')"
                :isArchived="(bool) request('archived')"
                :archiveRoute="route('job-vacancy.index', ['archived' => 'true'])"
                :activeRoute="route('job-vacancy.index')"
                :searchValue="request('search', '')"
                :placeholder="__('Search title or location...')"
            >
                <x-slot name="filters">
                    {{-- Type filter dropdown --}}
                    <form method="GET" action="{{ route('job-vacancy.index') }}" id="type-filter-form">
                        @foreach(request()->except(['type', 'page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <select name="type"
                                id="type-filter"
                                onchange="this.form.submit()"
                                class="text-sm px-3 py-2.5 rounded-xl
                                       bg-gray-50 dark:bg-slate-800/80
                                       border border-gray-200 dark:border-slate-700
                                       text-gray-600 dark:text-gray-300
                                       focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                       outline-none transition-all duration-200 cursor-pointer">
                            <option value="">{{ __('All Types') }}</option>
                            @foreach(array_keys($typeMap) as $t)
                                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>
                                    {{ $typeMap[$t]['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </x-slot>
            </x-table-toolbar>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-slate-800/60 border-b border-gray-100 dark:border-slate-700/50">
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Job Title') }}
                            </th>
                            @if($isAdmin)
                                <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                    {{ __('app.companies') }}
                                </th>
                            @endif
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Type') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Status') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Salary') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Location') }}
                            </th>
                            <th class="px-5 py-3.5 text-center text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Views') }}
                            </th>
                            <th class="px-5 py-3.5 text-end text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('app.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700/40">

                        @forelse($jobVacancies as $job)
                            @php
                                $typeInfo   = $typeMap[$job->type]   ?? ['label' => ucfirst($job->type), 'classes' => 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 ring-gray-100 dark:ring-slate-600'];
                                $statusInfo = $statusMap[$job->status] ?? ['label' => ucfirst($job->status ?? '—'), 'classes' => 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 ring-gray-100 dark:ring-slate-600'];
                            @endphp
                            <tr class="group hover:bg-gray-50/80 dark:hover:bg-slate-700/20 transition-colors duration-150">

                                {{-- Title --}}
                                <td class="px-5 py-4">
                                    @if(!request('archived'))
                                        <a href="{{ route('job-vacancy.show', $job->id) }}"
                                           class="text-sm font-semibold text-gray-900 dark:text-gray-100
                                                  hover:text-indigo-600 dark:hover:text-indigo-400
                                                  transition-colors duration-150 block truncate max-w-[220px]">
                                            {{ $job->title }}
                                        </a>
                                    @else
                                        <span class="text-sm font-medium text-gray-500 dark:text-slate-400">{{ $job->title }}</span>
                                    @endif
                                    @if($job->application_deadline)
                                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                                            {{ __('Deadline') }}: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Company (admin only) --}}
                                @if($isAdmin)
                                    <td class="px-5 py-4">
                                        @if($job->company)
                                            <a href="{{ route('company.show', $job->company->id) }}"
                                               class="text-sm font-medium text-indigo-600 dark:text-indigo-400
                                                      hover:text-indigo-700 dark:hover:text-indigo-300
                                                      transition-colors truncate block max-w-[140px]">
                                                {{ $job->company->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 dark:text-slate-600">—</span>
                                        @endif
                                    </td>
                                @endif

                                {{-- Type badge --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold ring-1 {{ $typeInfo['classes'] }}">
                                        {{ $typeInfo['label'] }}
                                    </span>
                                </td>

                                {{-- Status badge --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold ring-1 {{ $statusInfo['classes'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $job->status === 'open' ? 'bg-emerald-500' : ($job->status === 'closed' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>

                                {{-- Salary --}}
                                <td class="px-5 py-4">
                                    @if($job->salary)
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 tabular-nums">
                                            ${{ number_format($job->salary) }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-slate-600 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Location --}}
                                <td class="px-5 py-4">
                                    <span class="text-sm text-gray-600 dark:text-slate-400 truncate max-w-[120px] block">
                                        {{ $job->location ?: '—' }}
                                    </span>
                                </td>

                                {{-- Views + applies --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ number_format($job->view_count) }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                            </svg>
                                            {{ number_format($job->apply_count) }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if(!request('archived'))
                                            <a href="{{ route('job-vacancy.show', $job->id) }}"
                                               title="{{ __('View') }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                      text-gray-400 dark:text-slate-500
                                                      hover:text-indigo-600 dark:hover:text-indigo-400
                                                      hover:bg-indigo-50 dark:hover:bg-indigo-500/10
                                                      transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('job-vacancy.edit', $job->id) }}"
                                               title="{{ __('app.edit') }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                      text-gray-400 dark:text-slate-500
                                                      hover:text-amber-600 dark:hover:text-amber-400
                                                      hover:bg-amber-50 dark:hover:bg-amber-500/10
                                                      transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                </svg>
                                            </a>
                                            <button type="button"
                                                    title="{{ __('Archive') }}"
                                                    @click="$dispatch('open-modal', 'archive-job-{{ $job->id }}')"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                           text-gray-400 dark:text-slate-500
                                                           hover:text-red-600 dark:hover:text-red-400
                                                           hover:bg-red-50 dark:hover:bg-red-500/10
                                                           transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                </svg>
                                            </button>

                                            <x-confirm-modal
                                                :id="'archive-job-' . $job->id"
                                                :formAction="route('job-vacancy.destroy', $job->id)"
                                                formMethod="DELETE"
                                                :title="__('Archive Job Vacancy')"
                                                :message="__('Archive') . ' &quot;' . $job->title . '&quot;?'"
                                                :confirmLabel="__('Yes, Archive')"
                                                confirmClass="bg-red-600 hover:bg-red-700 focus:ring-red-500"
                                            />
                                        @else
                                            <form action="{{ route('job-vacancy.restore', $job->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        title="{{ __('Restore') }}"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                               text-gray-400 dark:text-slate-500
                                                               hover:text-emerald-600 dark:hover:text-emerald-400
                                                               hover:bg-emerald-50 dark:hover:bg-emerald-500/10
                                                               transition-all duration-150">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 9 : 8 }}" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.25" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        <p class="text-base font-semibold">
                                            {{ request('search') ? __('No results for') . ' "' . request('search') . '"' : __('No job vacancies found') }}
                                        </p>
                                        @if(!request('search'))
                                            <a href="{{ route('job-vacancy.create') }}"
                                               class="mt-1 inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                </svg>
                                                {{ __('Post the first job') }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($jobVacancies->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700/50 bg-gray-50/40 dark:bg-slate-800/30">
                    {{ $jobVacancies->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
