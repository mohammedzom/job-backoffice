<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Update Application Status') }}
            </h2>
            <a href="{{ route('job-application.show', $jobApplication->id) }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Details') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-8 border border-gray-100 dark:border-gray-700">
                
                <!-- Header Icon -->
                <div class="flex justify-center mb-6">
                    <div class="h-16 w-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-inner">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('Status Decision') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Review the applicant summary and make your decision') }}</p>
                </div>

                <!-- Read Only Info Summary -->
                <div class="mb-10 p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4">{{ __('Application Summary') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 mt-1 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold">
                                {{ strtoupper(substr($jobApplication->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">{{ __('Applicant') }}</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $jobApplication->user->name ?? __('Unknown') }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $jobApplication->user->email ?? '' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 mt-1 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">{{ __('Applied Position') }}</p>
                                <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $jobApplication->job->title ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $jobApplication->job->company->name ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('job-application.update', $jobApplication->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-10">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Update Status') }}</label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            
                            <!-- Pending -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="pending" class="peer sr-only" {{ $jobApplication->status == 'pending' ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 dark:peer-checked:border-amber-500 shadow-sm">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="h-12 w-12 mb-3 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="block text-base font-extrabold text-gray-900 dark:text-gray-100 mb-1">{{ __('Pending') }}</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Keep it under review') }}</span>
                                    </div>
                                    <!-- Indicator Ring -->
                                    <div class="absolute top-3 right-3 h-4 w-4 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-amber-500 peer-checked:bg-amber-500"></div>
                                </div>
                            </label>

                            <!-- Accepted -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="accepted" class="peer sr-only" {{ $jobApplication->status == 'accepted' ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 dark:peer-checked:border-emerald-500 shadow-sm">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="h-12 w-12 mb-3 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="block text-base font-extrabold text-gray-900 dark:text-gray-100 mb-1">{{ __('Accepted') }}</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Hire the applicant') }}</span>
                                    </div>
                                    <!-- Indicator Ring -->
                                    <div class="absolute top-3 right-3 h-4 w-4 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></div>
                                </div>
                            </label>

                            <!-- Rejected -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="status" value="rejected" class="peer sr-only" {{ $jobApplication->status == 'rejected' ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 transition-all peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 dark:peer-checked:border-red-500 shadow-sm">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="h-12 w-12 mb-3 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="block text-base font-extrabold text-gray-900 dark:text-gray-100 mb-1">{{ __('Rejected') }}</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Decline the offer') }}</span>
                                    </div>
                                    <!-- Indicator Ring -->
                                    <div class="absolute top-3 right-3 h-4 w-4 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-red-500 peer-checked:bg-red-500"></div>
                                </div>
                            </label>

                        </div>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <a href="{{ route('job-application.show', $jobApplication->id) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Save Decision') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
