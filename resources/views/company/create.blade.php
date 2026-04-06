{{--
    Shared form field macro — defined at top, reused through the form.
    Clean label + input with error state ring, RTL-safe padding.
--}}
<x-app-layout>
    <x-slot name="title">{{ __('Add Company') }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('company.index') }}"
               class="inline-flex items-center justify-center w-7 h-7 rounded-lg
                      text-gray-400 dark:text-slate-500
                      hover:text-indigo-600 dark:hover:text-indigo-400
                      hover:bg-indigo-50 dark:hover:bg-indigo-500/10
                      transition-all duration-150">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('Add New Company') }}</h1>
        </div>
    </x-slot>

    <div class="p-5 sm:p-6 lg:p-8 animate-fade-in">
        <x-toast-notification />

        <div class="max-w-3xl mx-auto">
            <form action="{{ route('company.store') }}" method="POST" id="company-create-form">
                @csrf

                {{-- ── Company Information Card ─────────────────────────── --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl
                            border border-gray-100 dark:border-slate-700/60
                            shadow-card overflow-hidden mb-5">

                    {{-- Card header --}}
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700/60
                                bg-gradient-to-r from-indigo-50/60 to-violet-50/40
                                dark:from-indigo-500/5 dark:to-violet-500/5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-500/15
                                    flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Company Details') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ __('Basic information about the company') }}</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Company Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Company Name') }}
                                <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <input
                                type="text" name="name" id="name"
                                value="{{ old('name') }}"
                                placeholder="{{ __('e.g. Acme Corporation') }}"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl
                                       bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('name') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500 dark:focus:border-indigo-400' }}
                                       text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                       focus:ring-2 outline-none transition-all duration-200"
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Industry --}}
                        <div>
                            <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Industry') }}
                                <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <select name="industry" id="industry"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl
                                       bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('industry') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                       text-gray-900 dark:text-gray-100
                                       focus:ring-2 outline-none transition-all duration-200">
                                @foreach($industries as $ind)
                                    <option value="{{ $ind }}" {{ old('industry') === $ind ? 'selected' : '' }}>
                                        {{ $ind }}
                                    </option>
                                @endforeach
                            </select>
                            @error('industry')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Website --}}
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Website') }}
                                <span class="text-xs text-gray-400 dark:text-slate-500 ms-1">({{ __('optional') }})</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3.284 14.253A8.959 8.959 0 013 12c0-1.016.132-2.002.381-2.938"/>
                                    </svg>
                                </div>
                                <input
                                    type="url" name="website" id="website"
                                    value="{{ old('website') }}"
                                    placeholder="https://example.com"
                                    class="block w-full ps-10 pe-3.5 py-2.5 text-sm rounded-xl
                                           bg-white dark:bg-slate-900/50
                                           border {{ $errors->has('website') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                           text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                           focus:ring-2 outline-none transition-all duration-200"
                                >
                            </div>
                            @error('website')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Address') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                </div>
                                <input
                                    type="text" name="address" id="address"
                                    value="{{ old('address') }}"
                                    placeholder="{{ __('123 Business Rd, City, Country') }}"
                                    class="block w-full ps-10 pe-3.5 py-2.5 text-sm rounded-xl
                                           bg-white dark:bg-slate-900/50
                                           border {{ $errors->has('address') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                           text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                           focus:ring-2 outline-none transition-all duration-200"
                                >
                            </div>
                            @error('address')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Owner Information Card ────────────────────────────── --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl
                            border border-gray-100 dark:border-slate-700/60
                            shadow-card overflow-hidden mb-6">

                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700/60
                                bg-gradient-to-r from-violet-50/60 to-purple-50/40
                                dark:from-violet-500/5 dark:to-purple-500/5">
                        <div class="w-8 h-8 rounded-xl bg-violet-100 dark:bg-violet-500/15
                                    flex items-center justify-center">
                            <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Owner Account') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ __('Admin credentials for this company') }}</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Owner Name --}}
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Owner Name') }} <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <input type="text" name="owner_name" id="owner_name"
                                value="{{ old('owner_name') }}"
                                placeholder="{{ __('e.g. John Doe') }}"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('owner_name') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                       text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                       focus:ring-2 outline-none transition-all duration-200">
                            @error('owner_name')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Owner Email --}}
                        <div>
                            <label for="owner_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Owner Email') }} <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <input type="email" name="owner_email" id="owner_email"
                                value="{{ old('owner_email') }}"
                                placeholder="name@example.com"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('owner_email') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                       text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                       focus:ring-2 outline-none transition-all duration-200">
                            @error('owner_email')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password with show/hide --}}
                        <div class="md:col-span-2" x-data="{ showPw: false }">
                            <label for="owner_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Password') }} <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPw ? 'text' : 'password'"
                                    name="owner_password" id="owner_password"
                                    autocomplete="new-password"
                                    placeholder="{{ __('Create a secure password') }}"
                                    class="block w-full ps-3.5 pe-11 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                           border {{ $errors->has('owner_password') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                           text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                           focus:ring-2 outline-none transition-all duration-200">
                                <button type="button" @click="showPw = !showPw"
                                        class="absolute inset-y-0 end-0 flex items-center pe-3.5
                                               text-gray-400 dark:text-slate-500
                                               hover:text-indigo-500 dark:hover:text-indigo-400
                                               focus:outline-none transition-colors">
                                    <svg x-show="!showPw" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <svg x-show="showPw" style="display:none;" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                            @error('owner_password')
                                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Form Actions ─────────────────────────────────────── --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('company.index') }}"
                       class="px-5 py-2.5 text-sm font-medium rounded-xl
                              text-gray-700 dark:text-gray-300
                              bg-white dark:bg-slate-800
                              border border-gray-200 dark:border-slate-600
                              hover:bg-gray-50 dark:hover:bg-slate-700
                              focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-slate-600
                              transition-all duration-150">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold rounded-xl text-white
                                   bg-gradient-to-br from-indigo-600 to-violet-600
                                   dark:from-indigo-500 dark:to-violet-500
                                   shadow-sm hover:from-indigo-500 hover:to-violet-500
                                   hover:shadow-indigo-500/30 hover:shadow-md
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/50
                                   transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        {{ __('Create Company') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
