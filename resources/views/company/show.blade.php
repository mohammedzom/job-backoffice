<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Company Profile') }}
            </h2>
            <a href="{{ route('company.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-12 text-white">
                    <div
                        class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                        <div
                            class="h-24 w-24 bg-white rounded-2xl flex items-center justify-center text-blue-600 font-bold text-4xl shadow-lg ring-4 ring-blue-400/30">
                            {{ strtoupper(substr($company->name, 0, 1)) }}
                        </div>
                        <div class="text-center sm:text-left mt-2">
                            <h3 class="text-3xl font-extrabold tracking-tight">{{ $company->name }}</h3>
                            <p
                                class="text-blue-100 mt-2 flex justify-center sm:justify-start items-center text-sm font-medium">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                {{ $company->industry }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Display -->
                <div class="p-8 border-b border-gray-100 dark:border-gray-700">
                    <h4
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">
                        {{ __('Company Details') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Location -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                {{ __('Location / Address') }}</p>
                            <div class="text-base text-gray-900 dark:text-gray-100 flex items-start mt-1">
                                <span
                                    class="bg-blue-100 dark:bg-gray-800 p-2 rounded-full mr-3 text-blue-600 dark:text-blue-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </span>
                                <span class="leading-relaxed">{{ $company->address ?: __('Not specified') }}</span>
                            </div>
                        </div>

                        <!-- Website -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                {{ __('Official Website') }}</p>
                            <div class="text-base flex items-center mt-1">
                                <span
                                    class="bg-indigo-100 dark:bg-gray-800 p-2 rounded-full mr-3 text-indigo-600 dark:text-indigo-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                        </path>
                                    </svg>
                                </span>
                                @if ($company->website)
                                    <a href="{{ $company->website }}" target="_blank"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium hover:underline transition">
                                        {{ str_replace(['http://', 'https://'], '', rtrim($company->website, '/')) }}
                                    </a>
                                @else
                                    <span
                                        class="text-gray-400 dark:text-gray-500 italic">{{ __('Not available') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div
                    class="px-8 py-5 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex flex-wrap gap-3 justify-end items-center">
                    <a href="{{ route('company.edit', $company->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        {{ __('Edit Company') }}
                    </a>

                    <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('{{ __('Are you sure you want to archive this company?') }}')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            {{ __('Archive') }}
                        </button>
                    </form>
                </div>

                {{-- Tabs Navigation --}}
                <div class="bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700 px-6 sm:px-8">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        @php $activeTab = request('tab', 'jobs') ?? 'jobs'; @endphp
                        <a href="?tab=jobs"
                            class="{{ $activeTab === 'jobs' ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ __('Jobs') }}
                            <span
                                class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-0.5 px-2.5 rounded-full text-xs">{{ $company->jobs->count() }}</span>
                        </a>
                        <a href="?tab=applications"
                            class="{{ $activeTab === 'applications' ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            {{ __('Applications') }}
                            <span
                                class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-0.5 px-2.5 rounded-full text-xs">{{ collect($company->jobs)->sum(fn($j) => collect($j->applications)->count()) }}</span>
                        </a>
                    </nav>
                </div>
                {{-- Tab Content --}}
                <div class="p-0 border-t border-gray-100 dark:border-gray-700">
                    <!-- Jobs Tab -->
                    <div id="jobs" class="{{ $activeTab === 'jobs' ? 'block' : 'hidden' }}">
                        @if ($company->jobs->isEmpty())
                            <div class="p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ __('No jobs found') }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('There are no jobs currently posted by this company.') }}</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Title') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Status') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700/50">
                                        @foreach ($company->jobs as $job)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div
                                                        class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $job->title }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusColors = match (strtolower($job->status ?? 'active')) {
                                                            'active',
                                                            'open'
                                                                => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 border-green-200 dark:border-green-800',
                                                            'closed'
                                                                => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400 border-red-200 dark:border-red-800',
                                                            'draft'
                                                                => 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                                                            default
                                                                => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="px-2.5 py-1 inline-flex text-xs font-medium rounded-full border {{ $statusColors }}">
                                                        {{ ucfirst($job->status ?? 'Active') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="#"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1.5 rounded-md transition-colors">{{ __('View Details') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <!-- Applications Tab -->
                    <div id="applications" class="{{ $activeTab === 'applications' ? 'block' : 'hidden' }}">
                        @php $applications = collect($company->jobs)->flatMap(fn($j) => $j->applications ?? collect()); @endphp
                        @if ($applications->isEmpty())
                            <div class="p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ __('No applications yet') }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('There are no applications submitted for this company\'s jobs.') }}</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Applicant') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Job Applied') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Status') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('AI Score') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('AI Feedback') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Date') }}</th>
                                            <th scope="col"
                                                class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700/50">
                                        @foreach ($applications as $application)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold text-xs ring-2 ring-white dark:ring-gray-800">
                                                            {{ strtoupper(substr($application->user->name ?? '?', 0, 1)) }}
                                                        </div>
                                                        <div class="ml-3">
                                                            <div
                                                                class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $application->user->name ?? 'Unknown' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-gray-200">
                                                        {{ $application->job->title ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusColors = match (
                                                            strtolower($application->status ?? 'pending')
                                                        ) {
                                                            'accepted'
                                                                => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                                                            'rejected'
                                                                => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                                                            default
                                                                => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="px-2.5 py-1 inline-flex text-xs font-medium rounded-full border {{ $statusColors }}">
                                                        {{ ucfirst($application->status ?? 'Pending') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if(isset($application->ai_generated_score) && $application->ai_generated_score !== null)
                                                    @php
                                                        $score = min(max($application->ai_generated_score * 10, 0), 100);
                                                        $barColor = match(true) {
                                                            $score >= 80 => 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]',
                                                            $score >= 60 => 'bg-green-400',
                                                            $score >= 45 => 'bg-yellow-400',
                                                            $score >= 30 => 'bg-orange-400',
                                                            default => 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.4)]'
                                                        };
                                                        $textColor = match(true) {
                                                            $score >= 80 => 'text-emerald-700 dark:text-emerald-400',
                                                            $score >= 60 => 'text-green-700 dark:text-green-500',
                                                            $score >= 45 => 'text-yellow-700 dark:text-yellow-500',
                                                            $score >= 30 => 'text-orange-700 dark:text-orange-500',
                                                            default => 'text-red-700 dark:text-red-500'
                                                        };
                                                    @endphp
                                                    <div class="flex items-center justify-center space-x-2.5">
                                                        <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 shadow-inner overflow-visible">
                                                            <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $score }}%"></div>
                                                        </div>
                                                        <span class="text-xs font-extrabold {{ $textColor }} inline-block w-8 text-left tabular-nums tracking-tight">
                                                            {{ round($score) }}%
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 dark:text-gray-600 text-sm">-</span>
                                                @endif
                                            </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if (!empty($application->ai_generated_feedback))
                                                        <div class="text-xs text-gray-600 dark:text-gray-400 max-w-[150px] truncate"
                                                            title="{{ $application->ai_generated_feedback }}">
                                                            {{ \Illuminate\Support\Str::limit($application->ai_generated_feedback, 30) }}
                                                        </div>
                                                    @else
                                                        <span
                                                            class="text-gray-400 dark:text-gray-600 text-xs italic">-</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $application->created_at ? $application->created_at->format('M d, Y') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="#"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1.5 rounded-md transition-colors">{{ __('View') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div> <!-- End Main Card -->
        </div>
    </div>
</x-app-layout>
