{{--
    Confirm Modal Component
    Usage:
      <x-confirm-modal
          id="delete-company-{{ $company->id }}"
          formAction="{{ route('company.destroy', $company->id) }}"
          formMethod="DELETE"
          title="Archive Company"
          message="Are you sure you want to archive this company?"
          confirmLabel="Yes, Archive"
          confirmClass="bg-red-600 hover:bg-red-700"
      />
      Then trigger with: document.getElementById('modal-delete-company-X').showModal()
      Or with Alpine: @click="$dispatch('open-modal', 'delete-company-{{ $id }}')"
--}}
@props([
    'id',
    'formAction',
    'formMethod' => 'DELETE',
    'title'      => 'Confirm Action',
    'message'    => 'Are you sure you want to proceed?',
    'confirmLabel' => 'Confirm',
    'confirmClass' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
])

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    id="confirm-modal-{{ $id }}"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 z-40 bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm"
        style="display: none;"
        aria-hidden="true"
    ></div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        @keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog" aria-modal="true" aria-labelledby="modal-title-{{ $id }}"
        style="display: none;"
    >
        <div class="relative w-full max-w-md bg-white dark:bg-slate-800
                    rounded-2xl shadow-[0_20px_60px_-10px_rgba(0,0,0,0.25)]
                    dark:shadow-[0_20px_60px_-10px_rgba(0,0,0,0.6)]
                    border border-gray-100 dark:border-slate-700 overflow-hidden">

            {{-- Danger icon header --}}
            <div class="flex items-center gap-4 px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                <div class="shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-500/15
                            flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="modal-title-{{ $id }}" class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ $title }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">{{ $message }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50/50 dark:bg-slate-800/50">
                <button
                    type="button"
                    @click="open = false"
                    class="px-4 py-2 text-sm font-medium rounded-xl
                           text-gray-700 dark:text-gray-300
                           bg-white dark:bg-slate-700
                           border border-gray-200 dark:border-slate-600
                           hover:bg-gray-50 dark:hover:bg-slate-600
                           focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-slate-500
                           transition-all duration-150"
                >
                    {{ __('app.cancel') }}
                </button>

                <form action="{{ $formAction }}" method="POST" class="inline">
                    @csrf
                    @method($formMethod)
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded-xl text-white
                               {{ $confirmClass }}
                               shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2
                               dark:focus:ring-offset-slate-800
                               transition-all duration-150"
                    >
                        {{ $confirmLabel }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
