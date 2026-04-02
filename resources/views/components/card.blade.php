@props([
    'title' => null,
    'editUrl' => null,
    'deleteUrl' => null,
    'actions' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden']) }}>
    
    @if($title || $actions || $editUrl || $deleteUrl)
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
        
        <div class="flex-1 font-semibold text-gray-900 dark:text-gray-100">
            {{ $title }}
        </div>

        <div class="flex items-center gap-2 rtl:space-x-reverse">
            {{ $actions }}
            
            @if($editUrl)
            <a href="{{ $editUrl }}" title="تعديل" class="inline-flex items-center justify-center p-2 text-sm font-medium text-amber-500 transition-colors bg-transparent rounded-lg hover:bg-amber-100 focus:ring-2 focus:outline-none focus:ring-amber-300 dark:text-amber-400 dark:bg-transparent dark:hover:bg-amber-900/50">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
            </a>
            @endif

            @if($deleteUrl)
            <form action="{{ $deleteUrl }}" method="POST" class="inline-flex m-0" onsubmit="return confirm('هل أنت متأكد أنك تريد الحذف؟');">
                @csrf
                @method('DELETE')
                <button type="submit" title="حذف" class="inline-flex items-center justify-center p-2 text-sm font-medium text-red-600 transition-colors bg-transparent rounded-lg hover:bg-red-100 focus:ring-2 focus:outline-none focus:ring-red-300 dark:text-red-400 dark:bg-transparent dark:hover:bg-red-900/50">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </form>
            @endif
        </div>
    </div>
    @endif

    <div class="p-6 text-gray-800 dark:text-gray-200">
        {{ $slot }}
    </div>
</div>
