<x-app-layout>
    <x-slot name="title">{{ __('app.companies') }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ __('app.companies') }}
            </h1>
            @if(request('archived'))
                <span class="text-xs px-2 py-0.5 rounded-lg bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-semibold">
                    {{ __('Archived') }}
                </span>
            @else
                <span class="text-xs px-2 py-0.5 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold">
                    {{ $companies->total() }} {{ __('total') }}
                </span>
            @endif
        </div>
    </x-slot>

    <div class="p-5 sm:p-6 lg:p-8 space-y-6 animate-fade-in">

        <x-toast-notification />

        {{-- Data table card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl
                    border border-gray-100 dark:border-slate-700/60
                    shadow-card overflow-hidden">

            {{-- Toolbar --}}
            <x-table-toolbar
                :searchRoute="route('company.index', request()->except(['search', 'page']))"
                :addRoute="route('company.create')"
                :addLabel="__('Add Company')"
                :isArchived="(bool) request('archived')"
                :archiveRoute="route('company.index', ['archived' => 'true'])"
                :activeRoute="route('company.index')"
                :searchValue="request('search', '')"
                :placeholder="__('Search by name, industry...')"
            />

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-slate-800/60 border-b border-gray-100 dark:border-slate-700/50">
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Company') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Industry') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Address') }}
                            </th>
                            <th class="px-5 py-3.5 text-start text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('Website') }}
                            </th>
                            <th class="px-5 py-3.5 text-end text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-slate-500">
                                {{ __('app.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700/40">

                        @forelse($companies as $company)
                            <tr class="group hover:bg-gray-50/80 dark:hover:bg-slate-700/20 transition-colors duration-150">

                                {{-- Company name + avatar --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Company avatar --}}
                                        <div class="w-9 h-9 rounded-xl shrink-0
                                                    bg-gradient-to-br from-indigo-500 to-violet-600
                                                    dark:from-indigo-400 dark:to-violet-500
                                                    flex items-center justify-center
                                                    text-white text-sm font-bold
                                                    shadow-sm ring-2 ring-white dark:ring-slate-800">
                                            {{ strtoupper(substr($company->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            @if(!request('archived'))
                                                <a href="{{ route('company.show', $company->id) }}"
                                                   class="text-sm font-semibold text-gray-900 dark:text-gray-100
                                                          hover:text-indigo-600 dark:hover:text-indigo-400
                                                          transition-colors duration-150 truncate block">
                                                    {{ $company->name }}
                                                </a>
                                            @else
                                                <span class="text-sm font-semibold text-gray-500 dark:text-slate-400">
                                                    {{ $company->name }}
                                                </span>
                                            @endif
                                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                                                {{ __('Since') }} {{ $company->created_at->format('M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Industry badge --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                                 bg-violet-50 dark:bg-violet-500/10
                                                 text-violet-700 dark:text-violet-300
                                                 ring-1 ring-violet-100 dark:ring-violet-500/20">
                                        {{ $company->industry }}
                                    </span>
                                </td>

                                {{-- Address --}}
                                <td class="px-5 py-4">
                                    <span class="text-sm text-gray-600 dark:text-slate-400 line-clamp-1">
                                        {{ $company->address ?: '—' }}
                                    </span>
                                </td>

                                {{-- Website --}}
                                <td class="px-5 py-4">
                                    @if($company->website)
                                        <a href="{{ $company->website }}" target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1 text-sm text-indigo-600 dark:text-indigo-400
                                                  hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                            </svg>
                                            <span class="truncate max-w-[140px]">
                                                {{ str_replace(['https://', 'http://'], '', rtrim($company->website, '/')) }}
                                            </span>
                                        </a>
                                    @else
                                        <span class="text-gray-300 dark:text-slate-600">—</span>
                                    @endif
                                </td>

                                {{-- Action buttons --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if(!request('archived'))
                                            {{-- View --}}
                                            <a href="{{ route('company.show', $company->id) }}"
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
                                            {{-- Edit --}}
                                            <a href="{{ route('company.edit', $company->id) }}"
                                               title="{{ __('app.edit') }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                      text-gray-400 dark:text-slate-500
                                                      hover:text-amber-600 dark:hover:text-amber-400
                                                      hover:bg-amber-50 dark:hover:bg-amber-500/10
                                                      transition-all duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                                </svg>
                                            </a>
                                            {{-- Archive (triggers modal) --}}
                                            <button type="button"
                                                    title="{{ __('Archive') }}"
                                                    @click="$dispatch('open-modal', 'archive-company-{{ $company->id }}')"
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
                                                :id="'archive-company-' . $company->id"
                                                :formAction="route('company.destroy', $company->id)"
                                                formMethod="DELETE"
                                                :title="__('Archive Company')"
                                                :message="__('Are you sure you want to archive') . ' ' . $company->name . '?'"
                                                :confirmLabel="__('Yes, Archive')"
                                                confirmClass="bg-red-600 hover:bg-red-700 focus:ring-red-500"
                                            />
                                        @else
                                            {{-- Restore --}}
                                            <form action="{{ route('company.restore', $company->id) }}" method="POST" class="inline">
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
                                <td colspan="5" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.25" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                        </svg>
                                        <p class="text-base font-semibold">
                                            {{ request('search') ? __('No results for') . ' "' . request('search') . '"' : __('No companies found') }}
                                        </p>
                                        @if(!request('search'))
                                            <a href="{{ route('company.create') }}"
                                               class="mt-1 inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                </svg>
                                                {{ __('Add the first company') }}
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
            @if($companies->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700/50 bg-gray-50/40 dark:bg-slate-800/30">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
