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
                        {{ __('Enter the details for the new job vacancy.') }}</p>
                </div>
                <div class="p-8">
                    <form action="{{ route('job-vacancy.update', $jobVacancy->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Company -->
                            <div class="md:col-span-2">
                                <label for="company_id"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Company') }}</label>
                                <select name="company_id" id="company_id"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('company_id') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                                    <option value="" disabled {{ old('company_id') ? '' : 'selected' }}>
                                        {{ __('Select a company') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company_id', $jobVacancy->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Job Title -->
                            <div class="md:col-span-2">
                                <label for="title"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Title') }}</label>
                                <input type="text" name="title" id="title"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('title', $jobVacancy->title) }}"
                                    placeholder="{{ __('e.g. Senior Software Engineer') }}">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Location') }}</label>
                                <input type="text" name="location" id="location"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('location') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('location', $jobVacancy->location) }}"
                                    placeholder="{{ __('e.g. San Francisco, CA or Remote') }}">
                                @error('location')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Salary -->
                            <div>
                                <label for="salary"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Annual Salary ($)') }}</label>
                                <input type="number" step="0.01" name="salary" id="salary"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('salary') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('salary', $jobVacancy->salary) }}"
                                    placeholder="{{ __('e.g. 120000') }}">
                                @error('salary')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Type') }}</label>
                                <select name="type" id="type"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('type') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                                    @foreach (['full_time', 'part_time', 'contract', 'remote', 'hybrid', 'other'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('type', $jobVacancy->type) == $type ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $type)) }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                                <select name="status" id="status"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('status') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                                    @foreach (['open', 'closed', 'pending'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $jobVacancy->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Application Deadline -->
                            <div>
                                <label for="application_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Application Deadline') }}</label>
                                <input type="date" name="application_deadline" id="application_deadline"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('application_deadline') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('application_deadline', $jobVacancy->application_deadline) }}">
                                @error('application_deadline')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Categories -->
                            <div x-data="{
                                init() {
                                    new TomSelect(this.$refs.select, {
                                        plugins: ['remove_button'],
                                        create: false,
                                        placeholder: '{{ __('Select categories...') }}',
                                        render: {
                                            item: function(data, escape) {
                                                return '<div>' + escape(data.text) + '</div>';
                                            }
                                        }
                                    });
                                }
                            }">
                                <label for="categories"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Categories') }}</label>
                                <div class="mt-2" dir="rtl">
                                    <select x-ref="select" multiple name="categories[]" id="categories" class="hidden {{ $errors->has('categories') || $errors->has('categories.*') ? 'border-red-500' : '' }}" autocomplete="off">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ collect(old('categories', $jobVacancy->categories->pluck('id')))->contains($category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('categories')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                                @error('categories.*')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Technologies -->
                            <div class="md:col-span-2">
                                <label for="technologies"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Technologies required (comma separated)') }}</label>
                                <input type="text" name="technologies" id="technologies"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('technologies') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('technologies', is_array($jobVacancy->technologies) ? implode(', ', $jobVacancy->technologies) : $jobVacancy->technologies) }}"
                                    placeholder="{{ __('e.g. PHP, Laravel, React, Tailwind CSS') }}">
                                @error('technologies')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Description') }}</label>
                                <textarea name="description" id="description" rows="6"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('description') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    placeholder="{{ __('Describe the responsibilities, requirements, and benefits...') }}">{{ old('description', $jobVacancy->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <a href="{{ route('job-vacancy.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all duration-300">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-medium text-sm rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5">
                                {{ __('Update Job Vacancy') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.default.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
    <style>
        /* TomSelect Tailwind & Dark Mode integration */
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
            background-color: rgb(34 139 230); /* Match image tag color approximately */
            color: white;
            border-radius: 0.25rem;
            align-items: center;
            display: inline-flex;
            gap: 0.5rem;
        }
        .ts-control .item .remove {
            color: white;
            opacity: 0.8;
            border-right: 1px solid rgba(255,255,255,0.3);
        }
        .ts-control .item .remove:hover {
            background: rgba(0,0,0,0.1);
            opacity: 1;
        }
    </style>
</x-app-layout>
