<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit company') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Edit Company Details') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Update the company information.') }}
                    </p>
                </div>
                <div class="p-8">
                    <form
                        action="{{ Auth::user()->role === 'admin' ? route('company.update', $company->id) : route('my-company.update') }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="md:col-span-2">
                                <label for="name"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Company Name') }}</label>
                                <input type="text" name="name" id="name"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('name', $company->name) }}"
                                    placeholder="{{ __('e.g. Acme Corporation') }}">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Company Industry -->
                            <div>
                                <label for="industry"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Industry') }}</label>
                                <select name="industry" id="industry"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('industry') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry }}"
                                            {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                            {{ $industry }}</option>
                                    @endforeach
                                </select>
                                @error('industry')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Company Website -->
                            <div>
                                <label for="website"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Website') }}</label>
                                <input type="url" name="website" id="website"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('website') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('website', $company->website) }}"
                                    placeholder="{{ __('https://example.com') }}">
                                @error('website')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Company Address -->
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Address') }}</label>
                                <input type="text" name="address" id="address"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('address') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('address', $company->address) }}"
                                    placeholder="{{ __('123 Business Rd, City, Country') }}">
                                @error('address')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <a href="{{ Auth::user()->role === 'admin' ? route('company.index') : route('my-company.show') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all duration-300">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-medium text-sm rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5">
                                {{ __('Update Company') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
