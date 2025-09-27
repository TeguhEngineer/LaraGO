<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-yellow-500 dark:from-yellow-500 to-yellow-600 dark:to-yellow-600 rounded hover:from-yellow-600 dark:hover:from-yellow-400 hover:to-yellow-700 dark:hover:to-yellow-500 transition-all duration-200']) }}>
    {{ $slot }}
</button>
