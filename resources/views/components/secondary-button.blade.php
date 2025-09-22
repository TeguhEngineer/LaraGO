<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 text-sm font-semibold text-secondary-700 dark:text-secondary-300 bg-secondary-200 hover:bg-secondary-300 dark:bg-secondary-700 rounded-md dark:hover:bg-secondary-600 hover:border-secondary-300 dark:hover:border-secondary-500 transition-all duration-200']) }}>
    {{ $slot }}
</button>
