<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add new job vacancy') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <x-toast-notification />
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Job Vacancy Details') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Enter the details for the new job vacancy.') }}
                    </p>
                </div>
                <div class="p-8">
                    <form action="{{ route('job-vacancy.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- ─── Company ─── --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Company') }}
                                </label>

                                @if ($isCompany)
                                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                                    <div
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/40 cursor-not-allowed">
                                        <div
                                            class="flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-indigo-500 dark:text-indigo-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $company->name }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                {{ __('Your company is automatically assigned') }}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('Fixed') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <select name="company_id" id="company_id"
                                            class="block w-full px-3.5 py-2.5 pe-10 text-sm rounded-xl
                                                   bg-white dark:bg-gray-900/50
                                                   border {{ $errors->has('company_id') ? 'border-red-400 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}
                                                   text-gray-900 dark:text-gray-100
                                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 dark:focus:border-indigo-400
                                                   appearance-none cursor-pointer transition-all duration-200">
                                            <option value="" disabled {{ old('company_id') ? '' : 'selected' }}>
                                                {{ __('Select a company') }}
                                            </option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3">
                                            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('company_id')
                                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>

                            {{-- ─── Job Title ─── --}}
                            <div class="md:col-span-2">
                                <label for="title"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Title') }}</label>
                                <input type="text" name="title" id="title"
                                    class="mt-2 block w-full px-3.5 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('title') }}"
                                    placeholder="{{ __('e.g. Senior Software Engineer') }}">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Location ─── --}}
                            <div>
                                <label for="location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Location') }}</label>
                                <input type="text" name="location" id="location"
                                    class="mt-2 block w-full px-3.5 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('location') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('location') }}"
                                    placeholder="{{ __('e.g. San Francisco, CA or Remote') }}">
                                @error('location')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Salary ─── --}}
                            <div x-data="{
                                value: '{{ old('salary') }}',
                                get formatted() {
                                    const n = parseFloat(this.value);
                                    if (!this.value || isNaN(n)) return null;
                                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 }).format(n);
                                }
                            }">
                                <label for="salary"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Annual Salary') }}</label>
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-sm font-bold text-indigo-400 dark:text-indigo-500">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="salary" id="salary" x-model="value"
                                        class="block w-full rounded-xl border pl-9 pr-20 py-2.5 text-sm font-medium bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition duration-150 {{ $errors->has('salary') ? 'border-red-400 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500' }}"
                                        placeholder="120,000" min="0">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span
                                            class="rounded-md bg-indigo-50 dark:bg-indigo-900/40 px-2 py-0.5 text-xs font-semibold text-indigo-500 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">USD
                                            / yr</span>
                                    </div>
                                </div>
                                <div x-show="formatted" x-cloak class="mt-2 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 text-emerald-500 shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                                        <span x-text="formatted"></span> {{ __('per year') }}
                                    </p>
                                </div>
                                @error('salary')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Job Type ─── --}}
                            <div class="md:col-span-2" x-data="{ selected: '{{ old('type', 'full_time') }}' }">
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('Job Type') }}</label>
                                <input type="hidden" name="type" :value="selected">
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                                    @php
                                        $jobTypes = [
                                            'full_time' => [
                                                'label' => 'Full Time',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />',
                                                'color' => 'indigo',
                                            ],
                                            'part_time' => [
                                                'label' => 'Part Time',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                                'color' => 'violet',
                                            ],
                                            'contract' => [
                                                'label' => 'Contract',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',
                                                'color' => 'amber',
                                            ],
                                            'remote' => [
                                                'label' => 'Remote',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
                                                'color' => 'emerald',
                                            ],
                                            'hybrid' => [
                                                'label' => 'Hybrid',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />',
                                                'color' => 'cyan',
                                            ],
                                            'other' => [
                                                'label' => 'Other',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                                'color' => 'gray',
                                            ],
                                        ];
                                        $colorMap = [
                                            'indigo' => [
                                                'ring' => 'ring-indigo-500',
                                                'bg' => 'bg-indigo-50 dark:bg-indigo-900/30',
                                                'icon' => 'text-indigo-600 dark:text-indigo-400',
                                                'text' => 'text-indigo-700 dark:text-indigo-300',
                                            ],
                                            'violet' => [
                                                'ring' => 'ring-violet-500',
                                                'bg' => 'bg-violet-50 dark:bg-violet-900/30',
                                                'icon' => 'text-violet-600 dark:text-violet-400',
                                                'text' => 'text-violet-700 dark:text-violet-300',
                                            ],
                                            'amber' => [
                                                'ring' => 'ring-amber-500',
                                                'bg' => 'bg-amber-50 dark:bg-amber-900/30',
                                                'icon' => 'text-amber-600 dark:text-amber-400',
                                                'text' => 'text-amber-700 dark:text-amber-300',
                                            ],
                                            'emerald' => [
                                                'ring' => 'ring-emerald-500',
                                                'bg' => 'bg-emerald-50 dark:bg-emerald-900/30',
                                                'icon' => 'text-emerald-600 dark:text-emerald-400',
                                                'text' => 'text-emerald-700 dark:text-emerald-300',
                                            ],
                                            'cyan' => [
                                                'ring' => 'ring-cyan-500',
                                                'bg' => 'bg-cyan-50 dark:bg-cyan-900/30',
                                                'icon' => 'text-cyan-600 dark:text-cyan-400',
                                                'text' => 'text-cyan-700 dark:text-cyan-300',
                                            ],
                                            'gray' => [
                                                'ring' => 'ring-gray-400',
                                                'bg' => 'bg-gray-50 dark:bg-gray-700/50',
                                                'icon' => 'text-gray-500 dark:text-gray-400',
                                                'text' => 'text-gray-600 dark:text-gray-400',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($jobTypes as $value => $config)
                                        @php $c = $colorMap[$config['color']]; @endphp
                                        <label @click="selected = '{{ $value }}'"
                                            :class="selected === '{{ $value }}' ?
                                                'ring-2 {{ $c['ring'] }} {{ $c['bg'] }} border-transparent' :
                                                'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40'"
                                            class="flex flex-col items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all duration-200 select-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="selected === '{{ $value }}' ? '{{ $c['icon'] }}' :
                                                    'text-gray-400 dark:text-gray-500'"
                                                class="w-6 h-6 transition-colors" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                {!! $config['icon'] !!}
                                            </svg>
                                            <span
                                                :class="selected === '{{ $value }}' ?
                                                    '{{ $c['text'] }} font-semibold' :
                                                    'text-gray-500 dark:text-gray-400 font-medium'"
                                                class="text-xs transition-colors text-center">
                                                {{ $config['label'] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Status ─── --}}
                            <div x-data="{ selected: '{{ old('status', 'open') }}' }">
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('Status') }}</label>
                                <input type="hidden" name="status" :value="selected">
                                <div
                                    class="flex rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 divide-x divide-gray-200 dark:divide-gray-700">
                                    @foreach (['open' => ['label' => 'Open', 'active' => 'bg-emerald-500 text-white', 'dot' => 'bg-emerald-400'], 'closed' => ['label' => 'Closed', 'active' => 'bg-red-500 text-white', 'dot' => 'bg-red-400'], 'pending' => ['label' => 'Pending', 'active' => 'bg-amber-500 text-white', 'dot' => 'bg-amber-400']] as $value => $config)
                                        <label @click="selected = '{{ $value }}'"
                                            :class="selected === '{{ $value }}' ? '{{ $config['active'] }}' :
                                                'bg-white dark:bg-gray-900/30 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/40'"
                                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 text-sm font-medium cursor-pointer transition-all duration-200 select-none">
                                            <span
                                                :class="selected === '{{ $value }}' ? '{{ $config['dot'] }}' :
                                                    'bg-gray-300 dark:bg-gray-600'"
                                                class="w-1.5 h-1.5 rounded-full transition-colors"></span>
                                            {{ $config['label'] }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Application Deadline ─── --}}
                            <div x-data="{
                                fp: null,
                                displayValue: '',
                                init() {
                                    this.fp = flatpickr(this.$refs.picker, {
                                        dateFormat: 'Y-m-d',
                                        altInput: true,
                                        altFormat: 'F j, Y',
                                        minDate: 'today',
                                        defaultDate: '{{ old('application_deadline') }}',
                                        onChange: (selectedDates, dateStr) => {
                                            this.displayValue = dateStr;
                                        },
                                        onReady: (selectedDates, dateStr) => {
                                            this.displayValue = dateStr;
                                        }
                                    });
                                }
                            }">
                                <label for="application_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Application Deadline') }}</label>
                                <div class="relative mt-1">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4 text-indigo-400 dark:text-indigo-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 005.25 9h13.5A2.25 2.25 0 0121 9v7.5M9 14.25h6" />
                                        </svg>
                                    </div>
                                    <input x-ref="picker" type="text" name="application_deadline"
                                        id="application_deadline"
                                        class="block w-full rounded-xl border pl-10 pr-4 py-2.5 text-sm bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition duration-150 {{ $errors->has('application_deadline') ? 'border-red-400 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500' }}"
                                        placeholder="{{ __('Pick a deadline...') }}" readonly>
                                </div>
                                @error('application_deadline')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Categories ─── --}}
                            <div x-data="{
                                selectedCount: 0,
                                init() {
                                    const colors = ['bg-violet-100 text-violet-700', 'bg-blue-100 text-blue-700', 'bg-emerald-100 text-emerald-700', 'bg-amber-100 text-amber-700', 'bg-rose-100 text-rose-700', 'bg-cyan-100 text-cyan-700', 'bg-fuchsia-100 text-fuchsia-700', 'bg-orange-100 text-orange-700'];
                                    const getColor = (text) => { let h = 0; for (let i = 0; i < text.length; i++) h = text.charCodeAt(i) + ((h << 5) - h); return colors[Math.abs(h) % colors.length]; };
                                    const ts = new TomSelect(this.$refs.select, {
                                        plugins: ['remove_button', 'checkbox_options'],
                                        create: false,
                                        maxOptions: 200,
                                        placeholder: '{{ __('Search and pick categories...') }}',
                                        render: {
                                            option: function(data, escape) {
                                                const [bg, text] = getColor(data.text).split(' ');
                                                return '<div class=\'flex items-center gap-2.5 py-0.5\'><span class=\'inline-flex items-center justify-center w-6 h-6 rounded ' + bg + ' ' + text + ' text-xs font-bold shrink-0\'>' + escape(data.text.charAt(0).toUpperCase()) + '</span><span class=\'text-sm\'>' + escape(data.text) + '</span></div>';
                                            },
                                            item: function(data, escape) {
                                                const [bg, text] = getColor(data.text).split(' ');
                                                return '<div class=\'' + bg + ' ' + text + ' text-xs font-semibold px-2 py-0.5 rounded-full flex items-center gap-1\'>' + escape(data.text) + '</div>';
                                            },
                                            no_results: () => '<div class=\'px-4 py-3 text-sm text-gray-400\'>{{ __('No categories found') }}</div>'
                                        },
                                        onItemAdd: () => { this.selectedCount = ts.items.length; },
                                        onItemRemove: () => { this.selectedCount = ts.items.length; },
                                    });
                                    this.selectedCount = ts.items.length;
                                }
                            }">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="categories"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Categories') }}</label>
                                    <span x-show="selectedCount > 0"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span x-text="selectedCount + ' {{ __('selected') }}'"></span>
                                    </span>
                                </div>
                                <select x-ref="select" multiple name="categories[]" id="categories"
                                    class="hidden {{ $errors->has('categories') || $errors->has('categories.*') ? 'border-red-500' : '' }}"
                                    autocomplete="off">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                                    {{ __('Type to search · Select one or more categories') }}</p>
                                @error('categories')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                                @error('categories.*')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Technologies ─── --}}
                            <div x-data="{
                                init() {
                                    new TomSelect(this.$refs.techSelect, {
                                        plugins: ['remove_button'],
                                        create: true,
                                        createOnBlur: true,
                                        delimiter: ',',
                                        persist: false,
                                        maxOptions: null,
                                        placeholder: '{{ __('Type a technology and press Enter...') }}',
                                        render: {
                                            item: function(data, escape) {
                                                return '<div class=\'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold px-2 py-0.5 rounded-full flex items-center gap-1\'>' + escape(data.text) + '</div>';
                                            },
                                            option_create: function(data, escape) {
                                                return '<div class=\'create px-4 py-2 text-sm text-indigo-600 dark:text-indigo-400\'><strong>+ {{ __('Add') }}:</strong> ' + escape(data.input) + '</div>';
                                            }
                                        }
                                    });
                                }
                            }">
                                <label for="technologies"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Technologies Required') }}</label>
                                <select x-ref="techSelect" multiple name="technologies[]" id="technologies"
                                    class="hidden {{ $errors->has('technologies') ? 'border-red-500' : '' }}">
                                    {{-- No pre-existing tags for create --}}
                                </select>
                                <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                                    {{ __('Type a technology and press Enter or comma to add it') }}</p>
                                @error('technologies')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ─── Description ─── --}}
                            <div class="md:col-span-2">
                                <label for="description"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Description') }}</label>
                                <textarea name="description" id="description" rows="6"
                                    class="mt-2 block w-full px-3.5 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('description') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    placeholder="{{ __('Describe the responsibilities, requirements, and benefits...') }}">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="mt-10 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <a href="{{ route('job-vacancy.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-medium text-sm rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5">
                                {{ __('Add Job Vacancy') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- TomSelect --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.default.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

    <style>
        /* ── TomSelect base ── */
        .ts-control {
            border-radius: 0.75rem;
            border-color: rgb(209 213 219);
            background-color: transparent;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            box-shadow: none;
        }

        .dark .ts-control {
            border-color: rgb(75 85 99);
            background-color: rgb(17 24 39 / 0.5);
            color: rgb(243 244 246);
        }

        .ts-control.focus {
            border-color: rgb(99 102 241);
            box-shadow: 0 0 0 1px rgb(99 102 241);
        }

        .dark .ts-control.focus {
            border-color: rgb(99 102 241);
            box-shadow: 0 0 0 1px rgb(99 102 241);
        }

        .ts-dropdown {
            border-radius: 0.75rem;
            border-color: rgb(209 213 219);
            background-color: white;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .dark .ts-dropdown {
            border-color: rgb(75 85 99);
            background-color: rgb(31 41 55);
            color: rgb(243 244 246);
        }

        .ts-dropdown .active {
            background-color: rgb(238 242 255);
            color: rgb(79 70 229);
        }

        .dark .ts-dropdown .active {
            background-color: rgb(55 65 81);
            color: rgb(129 140 248);
        }

        .ts-control input {
            color: inherit;
        }

        .dark .ts-control input {
            color: white;
        }

        .ts-control .item {
            border-radius: 9999px;
            align-items: center;
            display: inline-flex;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
        }

        .ts-control .item .remove {
            opacity: 0.7;
            border-right: none;
            margin-left: 0.125rem;
        }

        .ts-control .item .remove:hover {
            opacity: 1;
        }

        /* ── Flatpickr dark mode ── */
        .dark .flatpickr-calendar {
            background: rgb(31 41 55);
            border-color: rgb(75 85 99);
            box-shadow: 0 10px 25px rgb(0 0 0 / 0.4);
        }

        .dark .flatpickr-day {
            color: rgb(229 231 235);
        }

        .dark .flatpickr-day:hover {
            background: rgb(55 65 81);
        }

        .dark .flatpickr-day.selected,
        .dark .flatpickr-day.selected:hover {
            background: rgb(99 102 241);
            border-color: rgb(99 102 241);
            color: white;
        }

        .dark .flatpickr-day.today {
            border-color: rgb(99 102 241);
        }

        .dark .flatpickr-day.flatpickr-disabled {
            color: rgb(75 85 99);
        }

        .dark .flatpickr-months .flatpickr-month {
            color: rgb(229 231 235);
            fill: rgb(229 231 235);
        }

        .dark .flatpickr-current-month .numInputWrapper input {
            color: rgb(229 231 235);
        }

        .dark .flatpickr-weekday {
            color: rgb(156 163 175);
        }

        .dark .flatpickr-months .flatpickr-prev-month,
        .dark .flatpickr-months .flatpickr-next-month {
            fill: rgb(156 163 175);
        }

        .flatpickr-day.selected {
            background: rgb(99 102 241);
            border-color: rgb(99 102 241);
        }

        .flatpickr-day.today {
            border-color: rgb(99 102 241);
        }

        /* Style the alt input generated by flatpickr */
        .flatpickr-input.flatpickr-mobile {
            display: block !important;
        }
    </style>
</x-app-layout>
