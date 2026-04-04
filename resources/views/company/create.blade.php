<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add new company') }}
        </h2>
    </x-slot>
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <x-toast-notification />
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Company Details') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Enter the company information. This will be publicly visible to applicants.') }}</p>
                </div>
                <div class="p-8">
                    <form action="{{ route('company.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="md:col-span-2">
                                <label for="name"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Company Name') }}</label>
                                <input type="text" name="name" id="name"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('name') }}" placeholder="{{ __('e.g. Acme Corporation') }}">
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
                                        <option value="{{ $industry }}">{{ $industry }}</option>
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
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Website (optional)') }}</label>
                                <input type="url" name="website" id="website"
                                    class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('website') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                    value="{{ old('website') }}" placeholder="{{ __('https://example.com') }}">
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
                                    value="{{ old('address') }}"
                                    placeholder="{{ __('123 Business Rd, City, Country') }}">
                                @error('address')
                                    <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <!-- Divider -->
                        <div class="hidden sm:block my-8">
                            <div class="py-1">
                                <div class="border-t border-gray-200 dark:border-gray-700"></div>
                            </div>
                        </div>

                        <!-- Company Owner Section -->
                        <div>
                            <div class="mb-5">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ __('Company Owner Details') }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Provide the administrative user credentials for this new company.') }}</p>
                            </div>

                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                                <!-- Owner Name -->
                                <div>
                                    <label for="owner_name"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Owner Name') }}</label>
                                    <input type="text" name="owner_name" id="owner_name"
                                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('owner_name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                        value="{{ old('owner_name') }}" placeholder="{{ __('e.g. John Doe') }}">
                                    @error('owner_name')
                                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Owner Email -->
                                <div>
                                    <label for="owner_email"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Owner Email') }}</label>
                                    <input type="email" name="owner_email" id="owner_email"
                                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 {{ $errors->has('owner_email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                        value="{{ old('owner_email') }}" placeholder="{{ __('name@example.com') }}">
                                    @error('owner_email')
                                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Owner Password -->
                                <div class="md:col-span-2">
                                    <label for="owner_password"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Password') }}</label>
                                    <div class="relative mt-2" x-data="{ showPassword: false }">
                                        <input :type="showPassword ? 'text' : 'password'" name="owner_password"
                                            id="owner_password" required autocomplete="new-password"
                                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 pr-10 {{ $errors->has('owner_password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                            placeholder="{{ __('Create a secure password') }}">

                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-500 dark:text-gray-500 dark:hover:text-indigo-400 focus:outline-none transition-colors">
                                            <!-- Open Eye -->
                                            <svg x-show="showPassword" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <!-- Closed Eye -->
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('owner_password')
                                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div
                            class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <a href="{{ route('company.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all duration-300">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-medium text-sm rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5">
                                {{ __('Add Company') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
