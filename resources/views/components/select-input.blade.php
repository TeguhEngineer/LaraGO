@props(['placeholder' => null, 'selected' => null])

<select
    {{ $attributes->merge([
        'class' =>
            'w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded focus:outline-none focus:border-primary-400 dark:focus:border-primary-400 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500',
    ]) }}>
    @if ($placeholder)
        <option disabled {{ $selected ? '' : 'selected' }}>
            {{ $placeholder }}
        </option>
    @endif

    {{ $slot }}
</select>
