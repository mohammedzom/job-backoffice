<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">

            <form action="{{ route('job-category.update', $jobCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">

                    <label for="name"
                        class="block text-sm font-medium text-gray-700">{{ __('Category name') }}</label>
                    <input type="text" name="name" id="name"
                        class="{{ $errors->has('name') ? 'outline-red-500' : '' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('name', $jobCategory->name) }}">
                    @error('name')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-4">

                    <a href="{{ route('job-category.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">{{ __('Cancel') }}</a>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">{{ __('Update Category') }}</button>
            </form>
        </div>

    </div>
    </div>

</x-app-layout>
