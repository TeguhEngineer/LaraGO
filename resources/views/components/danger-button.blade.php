<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-red-500 dark:from-red-500 to-red-600 dark:to-red-600 rounded hover:from-red-600 dark:hover:from-red-400 hover:to-red-700 dark:hover:to-red-500 transition-all duration-200']) }}>
    {{ $slot }}
</button>
