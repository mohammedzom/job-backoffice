<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Companies') }} {{ request('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-y-auto p-6">
        <x-toast-notification />


        <div class="flex justify-between items-center mb-6">
            {{-- Filters --}}
            <div class="flex">
                @if (request('archived'))
                    <a href="{{ route('company.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                        <svg class="w-4 h-4 me-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Active') }}
                    </a>
                @else
                    <a href="{{ route('company.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                        <svg class="w-4 h-4 me-2 text-indigo-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        {{ __('Archived') }}
                    </a>
                @endif
            </div>

            {{-- Add Button --}}
            <a href="{{ route('company.create') }}"
                class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-5 h-5 me-2 transition-transform duration-300 group-hover:rotate-90" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Add New Company') }}
            </a>
        </div>

        {{-- Table Category --}}
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 rounded-lg shadow mt-4 bg-white">
            <thead>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    {{ __('Company Name') }}</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    {{ __('Company Address') }}</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    {{ __('Company Industry') }}</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    {{ __('Company Website') }}</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    {{ __('Actions') }}</th>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-gray-800">{{ $company->name }}</td>
                        <td class="px-6 py-3 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-3 text-gray-800">{{ $company->industry }}</td>
                        <a href="{{ $company->website }}" target="_blank">
                            <td class="px-6 py-3 text-gray-800">{{ $company->website }}</td>
                        </a>
                        <td>
                            <div class="flex space-x-5">
                                @if (!request('archived'))
                                    <a href="{{ route('company.edit', $company->id) }}"
                                        class="text-blue-500  hover:text-blue-700">✍🏻 Edit</a>
                                @endif
                                @if (!request('archived'))
                                    <form action="{{ route('company.destroy', $company->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700" type="submit">🗃️
                                            Archive</button>
                                    </form>
                                @else
                                    <form action="{{ route('company.restore', $company->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-green-500 hover:text-green-700" type="submit">♻️
                                            Restore</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-3 text-gray-800">{{ __('No companies found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>
