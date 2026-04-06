@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'block w-full px-3.5 py-2.5 text-sm
                text-gray-900 dark:text-gray-100
                bg-white dark:bg-slate-900/50
                border border-gray-300 dark:border-slate-600
                rounded-xl shadow-sm
                placeholder-gray-400 dark:placeholder-slate-500
                focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 dark:focus:border-indigo-400
                disabled:opacity-60 disabled:cursor-not-allowed
                transition-all duration-200',
]) }}>
