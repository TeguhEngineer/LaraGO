<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-primary-400 dark:from-primary-500 to-primary-500 dark:to-primary-600 rounded hover:from-primary-500 dark:hover:from-primary-400 hover:to-primary-600 dark:hover:to-primary-500 transition-all duration-200']) }}>
    {{ $slot }}
</button>
