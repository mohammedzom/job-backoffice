<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Job Vacancy Details') }}
            </h2>
            <a href="{{ route('job-vacancy.index') }}"
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
                            {{ strtoupper(substr($jobVacancy->title, 0, 1)) }}
                        </div>
                        <div class="text-center sm:text-left mt-2 w-full">
                            <h3 class="text-3xl font-extrabold tracking-tight">{{ $jobVacancy->title }}</h3>
                            <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-4">
                                <p
                                    class="text-blue-100 flex items-center text-sm font-medium bg-blue-800/30 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1.5 opacity-80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    {{ $jobVacancy->company->name ?? __('Unknown Company') }}
                                </p>
                                <p
                                    class="text-blue-100 flex items-center text-sm font-medium bg-indigo-800/30 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1.5 opacity-80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $jobVacancy->location }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Display -->
                <div class="p-8 border-b border-gray-100 dark:border-gray-700">
                    <h4
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">
                        {{ __('Job Details') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Salary -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                                {{ __('Salary') }}</p>
                            <p class="text-base text-gray-900 dark:text-gray-100 font-medium">
                                @if ($jobVacancy->salary)
                                    ${{ number_format($jobVacancy->salary, 2) }}
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </p>
                        </div>
                        <!-- Job Type -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                                {{ __('Job Type') }}</p>
                            <p class="text-base font-medium">
                                @php
                                    $typeColors = [
                                        'full_time' => 'text-blue-700 dark:text-blue-400',
                                        'part_time' => 'text-purple-700 dark:text-purple-400',
                                        'contract' => 'text-pink-700 dark:text-pink-400',
                                        'remote' => 'text-emerald-700 dark:text-emerald-400',
                                        'hybrid' => 'text-cyan-700 dark:text-cyan-400',
                                    ];
                                    $typeClass = $typeColors[$jobVacancy->type] ?? 'text-gray-700 dark:text-gray-300';
                                @endphp
                                <span
                                    class="{{ $typeClass }}">{{ ucwords(str_replace('_', ' ', $jobVacancy->type)) }}</span>
                            </p>
                        </div>
                        <!-- Status -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                                {{ __('Status') }}</p>
                            <p class="text-base font-medium">
                                @php
                                    $statusColors = [
                                        'open' => 'text-emerald-600 dark:text-emerald-400',
                                        'closed' => 'text-red-600 dark:text-red-400',
                                        'pending' => 'text-amber-600 dark:text-amber-400',
                                    ];
                                    $statusClass =
                                        $statusColors[$jobVacancy->status] ?? 'text-gray-600 dark:text-gray-400';
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($jobVacancy->status) }}</span>
                            </p>
                        </div>
                        <!-- Deadline -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p
                                class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                                {{ __('Deadline') }}</p>
                            <p class="text-base text-gray-900 dark:text-gray-100 font-medium">
                                {{ $jobVacancy->application_deadline ? \Carbon\Carbon::parse($jobVacancy->application_deadline)->format('M d, Y') : __('Not set') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <h4
                                class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                {{ __('Job Description') }}</h4>
                            <div
                                class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg border border-gray-100 dark:border-gray-800 whitespace-pre-wrap">
                                {{ $jobVacancy->description }}</div>
                        </div>

                        <!-- Technologies -->
                        @if ($jobVacancy->technologies)
                            <div>
                                <h4
                                    class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                    {{ __('Technologies Required') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $techs = is_array($jobVacancy->technologies)
                                            ? $jobVacancy->technologies
                                            : json_decode($jobVacancy->technologies, true);
                                    @endphp
                                    @if (is_array($techs))
                                        @foreach ($techs as $tech)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Categories -->
                        @if ($jobVacancy->categories && $jobVacancy->categories->count() > 0)
                            <div>
                                <h4
                                    class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                    {{ __('Categories') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($jobVacancy->categories as $category)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/30 dark:text-fuchsia-400 border border-fuchsia-200 dark:border-fuchsia-800">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div
                    class="px-8 py-5 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex flex-wrap gap-3 justify-end items-center">
                    <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        {{ __('Edit') }}
                    </a>

                    <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('{{ __('Are you sure you want to archive this job vacancy?') }}')"
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

                <!-- Applications Section Title -->
                <div class="px-8 py-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Applications for this Job') }}</h3>
                </div>

                <!-- Applications List Tab -->
                <div class="px-0 pb-0">
                    @php
                        $applications = collect($jobVacancy->applications ?? []);
                    @endphp
                    @if ($applications->isEmpty())
                        <div class="p-12 text-center border-t border-gray-100 dark:border-gray-700">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ __('No applications yet') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('There are no applications submitted for this job vacancy yet.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border-t border-gray-100 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/40">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Applicant') }}</th>
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
                                                @if (isset($application->ai_generated_score) && $application->ai_generated_score !== null)
                                                    @php
                                                        $score = min(
                                                            max($application->ai_generated_score * 10, 0),
                                                            100,
                                                        );
                                                        $barColor = match (true) {
                                                            $score >= 80
                                                                => 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]',
                                                            $score >= 60 => 'bg-green-400',
                                                            $score >= 45 => 'bg-yellow-400',
                                                            $score >= 30 => 'bg-orange-400',
                                                            default
                                                                => 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.4)]',
                                                        };
                                                        $textColor = match (true) {
                                                            $score >= 80 => 'text-emerald-700 dark:text-emerald-400',
                                                            $score >= 60 => 'text-green-700 dark:text-green-500',
                                                            $score >= 45 => 'text-yellow-700 dark:text-yellow-500',
                                                            $score >= 30 => 'text-orange-700 dark:text-orange-500',
                                                            default => 'text-red-700 dark:text-red-500',
                                                        };
                                                    @endphp
                                                    <div class="flex items-center justify-center space-x-2.5">
                                                        <div
                                                            class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 shadow-inner overflow-visible">
                                                            <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-500"
                                                                style="width: {{ $score }}%"></div>
                                                        </div>
                                                        <span
                                                            class="text-xs font-extrabold {{ $textColor }} inline-block w-8 text-left tabular-nums tracking-tight">{{ round($score) }}%</span>
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
        </div>
    </div>
</x-app-layout>
