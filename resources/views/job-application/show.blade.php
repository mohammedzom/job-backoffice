<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <a href="{{ route('job-application.index') }}"
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left column (Applicant details & Summary) -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Applicant Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                        <div class="p-8 text-center border-b border-gray-100 dark:border-gray-700">
                            <div
                                class="h-24 w-24 mx-auto rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-3xl shadow-sm ring-4 ring-indigo-50 dark:ring-gray-700">
                                {{ strtoupper(substr($jobApplication->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $jobApplication->user->name ?? __('Unknown Applicant') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $jobApplication->user->email ?? '' }}</p>

                            <div class="mt-6 flex justify-center">
                                @php
                                    $statusColors = [
                                        'pending' =>
                                            'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                                        'accepted' =>
                                            'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                                        'rejected' =>
                                            'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                                    ];
                                    $colorClass =
                                        $statusColors[$jobApplication->status] ??
                                        'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 border-gray-200 dark:border-gray-800';
                                @endphp
                                <span
                                    class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-sm border {{ $colorClass }}">
                                    {{ ucfirst($jobApplication->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50">
                            <!-- Basic details -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Applied On') }}</span>
                                    <span
                                        class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $jobApplication->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Resume Attached') }}</span>
                                    @if ($jobApplication->resume_id)
                                        <span
                                            class="inline-flex items-center text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            {{ __('Yes') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-sm font-semibold text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            {{ __('No') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column (Job & AI Details) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Job Info Card -->
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-8 border border-gray-100 dark:border-gray-700">
                        <div
                            class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('Applied Position') }}
                            </h4>
                            <a href="{{ route('job-vacancy.show', $jobApplication->job->id) }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ __('View Job') }} &rarr;
                            </a>
                        </div>

                        <div>
                            <h3 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">
                                {{ $jobApplication->job->title ?? __('N/A') }}</h3>
                            <p class="text-md text-gray-500 dark:text-gray-400 mt-2 font-medium">
                                {{ $jobApplication->job->company->name ?? __('Unknown Company') }} &bull;
                                {{ $jobApplication->job->location ?? __('Unknown Location') }}</p>
                        </div>
                    </div>

                    <!-- AI Insights Card -->
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-gray-800 dark:to-indigo-900/20 overflow-hidden shadow-xl sm:rounded-xl border border-indigo-100 dark:border-indigo-900/50">
                        <div class="p-8">
                            <div
                                class="flex items-center justify-between border-b border-indigo-200/50 dark:border-indigo-800/50 pb-4 mb-6">
                                <h4 class="text-lg font-bold text-indigo-900 dark:text-indigo-100 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ __('AI Applicant Analysis') }}
                                </h4>
                            </div>

                            @if ($jobApplication->ai_generated_score !== null)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Score Display -->
                                    <div
                                        class="md:col-span-1 flex flex-col items-center justify-center bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-indigo-50 dark:border-gray-700">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">
                                            {{ __('Match Score') }}</p>
                                        @php
                                            $score = min(max($jobApplication->ai_generated_score, 0), 100);
                                            $textColor = match (true) {
                                                $score >= 80 => 'text-emerald-500',
                                                $score >= 60 => 'text-green-500',
                                                $score >= 45 => 'text-yellow-500',
                                                $score >= 30 => 'text-orange-500',
                                                default => 'text-red-500',
                                            };
                                        @endphp
                                        <div class="relative w-32 h-32 flex items-center justify-center">
                                            <!-- Simple CSS Circle -->
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                <path class="text-gray-100 dark:text-gray-700" fill="none"
                                                    stroke="currentColor" stroke-width="3"
                                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                <path class="{{ $textColor }}" fill="none" stroke="currentColor"
                                                    stroke-dasharray="{{ $score }}, 100" stroke-width="3"
                                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            </svg>
                                            <div class="absolute flex flex-col items-center">
                                                <span
                                                    class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $score }}<span
                                                        class="text-lg">%</span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Feedback Display -->
                                    <div
                                        class="md:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-indigo-50 dark:border-gray-700">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            {{ __('AI Feedback') }}</p>
                                        <div class="prose dark:prose-invert text-gray-700 dark:text-gray-300 text-sm">
                                            {{ $jobApplication->ai_generated_feedback ?: __('No detailed feedback provided by AI.') }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl text-center border border-indigo-50 dark:border-gray-700">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">
                                        {{ __('AI Score and Feedback are pending or unavailable.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Resume Details Card -->
                    @if ($jobApplication->resume_id)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 dark:border-gray-700">
                            <!-- Header -->
                            <div
                                class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    {{ __('Applicant Resume Detailed') }}
                                </h4>
                                <a href="{{ env('APP_URL') . '/storage/' . $jobApplication->resume->file_url }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    {{ __('Download PDF') }}
                                </a>
                            </div>

                            <div class="p-8 space-y-8">
                                <!-- Summary Section -->
                                @if ($jobApplication->resume->summary)
                                    <div>
                                        <h5
                                            class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            {{ __('Professional Summary') }}
                                        </h5>
                                        <div
                                            class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-wrap bg-gray-50 dark:bg-gray-900/40 p-5 rounded-xl border border-gray-100 dark:border-gray-800">
                                            {{ $jobApplication->resume->summary }}</div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Skills Section -->
                                    @php
                                        $skills = is_array($jobApplication->resume->skills)
                                            ? $jobApplication->resume->skills
                                            : [];
                                    @endphp
                                    @if (count($skills) > 0)
                                        <div>
                                            <h5
                                                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                {{ __('Skills & Expertise') }}
                                            </h5>
                                            <div
                                                class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-5 border border-gray-100 dark:border-gray-800 min-h-[120px]">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($skills as $skill)
                                                        @if (is_string($skill) && trim($skill))
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                                {{ trim($skill) }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Education Section -->
                                    @php
                                        $eduItems = is_array($jobApplication->resume->education)
                                            ? $jobApplication->resume->education
                                            : [];
                                    @endphp
                                    @if (count($eduItems) > 0)
                                        <div>
                                            <h5
                                                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 14v6"></path>
                                                </svg>
                                                {{ __('Education') }}
                                            </h5>
                                            <div
                                                class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-5 border border-gray-100 dark:border-gray-800 min-h-[120px] space-y-3">
                                                @foreach ($eduItems as $edu)
                                                    <div
                                                        class="border-b border-gray-200 dark:border-gray-700 last:border-0 pb-3 last:pb-0">
                                                        @if (isset($edu['degree']))
                                                            <div
                                                                class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                                {{ $edu['degree'] }}</div>
                                                        @endif
                                                        @if (isset($edu['field_of_study']))
                                                            <div
                                                                class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">
                                                                {{ $edu['field_of_study'] }}</div>
                                                        @endif
                                                        @if (isset($edu['university']))
                                                            <div
                                                                class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-0.5">
                                                                {{ $edu['university'] }}</div>
                                                        @endif
                                                        @if (isset($edu['graduation_year']))
                                                            <div
                                                                class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                                {{ $edu['graduation_year'] }}</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Experience Section -->
                                @php
                                    $expItems = is_array($jobApplication->resume->experience)
                                        ? $jobApplication->resume->experience
                                        : [];
                                @endphp
                                @if (count($expItems) > 0)
                                    <div>
                                        <h5
                                            class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-indigo-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ __('Work Experience') }}
                                        </h5>
                                        <div
                                            class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-6 border border-gray-100 dark:border-gray-800 space-y-4">
                                            @foreach ($expItems as $exp)
                                                <div
                                                    class="border-b border-gray-200 dark:border-gray-700 last:border-0 pb-4 last:pb-0">
                                                    @if (isset($exp['position']))
                                                        <div
                                                            class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                            {{ $exp['position'] }}</div>
                                                    @endif
                                                    @if (isset($exp['company']))
                                                        <div
                                                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-0.5">
                                                            {{ $exp['company'] }}</div>
                                                    @endif
                                                    @if (isset($exp['start_date']) || isset($exp['end_date']))
                                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                            {{ $exp['start_date'] ?? '' }}
                                                            @if (isset($exp['start_date']) && isset($exp['end_date']))
                                                                &ndash;
                                                            @endif
                                                            {{ $exp['end_date'] ?? '' }}
                                                        </div>
                                                    @endif
                                                    @if (isset($exp['responsibilities']) && $exp['responsibilities'])
                                                        <p
                                                            class="text-xs text-gray-600 dark:text-gray-400 mt-1.5 leading-relaxed">
                                                            {{ $exp['responsibilities'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- No Resume Card -->
                        <div
                            class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-8 border border-dashed border-gray-300 dark:border-gray-700 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ __('No Resume Attached') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('This applicant didn\'t provide a parsed resume.') }}</p>
                        </div>
                    @endif
                    <!-- Actions Card -->
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-8 border border-gray-100 dark:border-gray-700 flex flex-wrap gap-4 items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Application Actions') }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('Update status or archive this application') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('job-application.edit', $jobApplication->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                {{ __('Update Status') }}
                            </a>
                            @if (!$isCompany)
                                <form action="{{ route('job-application.destroy', $jobApplication->id) }}"
                                    method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('{{ __('Are you sure you want to archive this job application?') }}')"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        {{ __('Archive') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
