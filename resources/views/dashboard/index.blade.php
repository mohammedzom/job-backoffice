<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">
        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Active Users') }}</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ $analytics['activeUsers_last_30_days'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Last 30 days') }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Total Jobs') }}</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('All Time') }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Total Applications') }}</h3>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $analytics['totalApplications'] }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('All Time') }}</p>
            </div>
        </div>
        {{-- Most Applied Jobs --}}
        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Most Applied Jobs') }}</h3>
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Job Title') }}</th>
                        @if ($user->role === 'admin')
                            <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Company') }}</th>
                        @endif
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Total Applications') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="py-4">{{ $job->title }}</td>
                            @if ($user->role === 'admin')
                                <td class="py-4">{{ $job->company->name }}</td>
                            @endif
                            <td class="py-4">{{ $job->apply_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Conversion Rate --}}
        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Conversion Rate') }}</h3>
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Job Title') }}</th>
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Views') }}</th>
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Applications') }}</th>
                        <th class="py-2 uppercase text-gray-500 dark:text-gray-400">{{ __('Conversion Rate') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($analytics['conversionData'] as $job)
                        <tr>
                            <td class="py-4">{{ $job->title }}</td>
                            <td class="py-4">{{ $job->view_count }}</td>
                            <td class="py-4">{{ $job->apply_count }}</td>
                            <td class="py-4">{{ $job->calculated_conversion_rate }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
