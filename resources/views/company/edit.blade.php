<x-app-layout>
    <x-slot name="title">{{ __('Edit Company') }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ Auth::user()->role === 'admin' ? route('company.index') : route('my-company.show') }}"
               class="inline-flex items-center justify-center w-7 h-7 rounded-lg
                      text-gray-400 dark:text-slate-500
                      hover:text-indigo-600 dark:hover:text-indigo-400
                      hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all duration-150">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('Edit Company') }}</h1>
            <span class="text-sm text-gray-400 dark:text-slate-500">— {{ $company->name }}</span>
        </div>
    </x-slot>

    <div class="p-5 sm:p-6 lg:p-8 animate-fade-in">
        <x-toast-notification />

        <div class="max-w-3xl mx-auto">

            {{-- Validation summary --}}
            @if($errors->any())
                <div class="mb-5 flex items-start gap-3 px-4 py-3.5 rounded-2xl
                            bg-red-50 dark:bg-red-900/15
                            border border-red-200 dark:border-red-500/25
                            text-red-700 dark:text-red-400">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ __('Please fix the errors below') }}</p>
                        <ul class="mt-1 text-xs space-y-0.5 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ Auth::user()->role === 'admin' ? route('company.update', $company->id) : route('my-company.update') }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-slate-800 rounded-2xl
                            border border-gray-100 dark:border-slate-700/60
                            shadow-card overflow-hidden mb-6">

                    {{-- Card header --}}
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700/60
                                bg-gradient-to-r from-amber-50/60 to-orange-50/40
                                dark:from-amber-500/5 dark:to-orange-500/5">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-500/15
                                    flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Update Company Details') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-slate-400">{{ __('Changes will be reflected immediately') }}</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                {{ __('Company Name') }} <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $company->name) }}"
                                placeholder="{{ __('e.g. Acme Corporation') }}"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('name') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                       text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                       focus:ring-2 outline-none transition-all duration-200">
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
                                {{ __('Industry') }} <span class="text-red-500 ms-0.5">*</span>
                            </label>
                            <select name="industry" id="industry"
                                class="block w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                       border {{ $errors->has('industry') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                       text-gray-900 dark:text-gray-100
                                       focus:ring-2 outline-none transition-all duration-200">
                                @foreach($industries as $ind)
                                    <option value="{{ $ind }}" {{ old('industry', $company->industry) === $ind ? 'selected' : '' }}>
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
                                <input type="url" name="website" id="website"
                                    value="{{ old('website', $company->website) }}"
                                    placeholder="https://example.com"
                                    class="block w-full ps-10 pe-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                           border {{ $errors->has('website') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                           text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                           focus:ring-2 outline-none transition-all duration-200">
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
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $company->address) }}"
                                    placeholder="{{ __('123 Business Rd, City, Country') }}"
                                    class="block w-full ps-10 pe-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-slate-900/50
                                           border {{ $errors->has('address') ? 'border-red-400 dark:border-red-500 focus:ring-red-500/30 focus:border-red-500' : 'border-gray-200 dark:border-slate-600 focus:ring-indigo-500/30 focus:border-indigo-500' }}
                                           text-gray-900 dark:text-gray-100 placeholder-gray-300 dark:placeholder-slate-600
                                           focus:ring-2 outline-none transition-all duration-200">
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

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ Auth::user()->role === 'admin' ? route('company.index') : route('my-company.show') }}"
                       class="px-5 py-2.5 text-sm font-medium rounded-xl
                              text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800
                              border border-gray-200 dark:border-slate-600
                              hover:bg-gray-50 dark:hover:bg-slate-700
                              focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-slate-600
                              transition-all duration-150">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold rounded-xl text-white
                                   bg-gradient-to-br from-amber-500 to-orange-500
                                   dark:from-amber-400 dark:to-orange-400
                                   shadow-sm hover:from-amber-400 hover:to-orange-400
                                   hover:shadow-amber-500/25 hover:shadow-md
                                   focus:outline-none focus:ring-2 focus:ring-amber-500/50
                                   transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
