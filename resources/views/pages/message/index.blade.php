<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Send Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('send.message') }}">
                        @csrf

                        {{-- WhatsApp Number --}}
                        <div class="mb-4">
                            <x-input-label for="phone" value="WhatsApp Number" />
                            <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full"
                                placeholder="Example: 6281234567890" value="{{ old('phone') }}" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        {{-- Message --}}
                        <div class="mb-4">
                            <x-input-label for="message" value="Message" />
                            <textarea id="message" name="message" rows="4"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center">
                            <x-primary-button>Send</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
