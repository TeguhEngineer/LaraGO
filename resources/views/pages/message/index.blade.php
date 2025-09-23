<x-app-layout>
    <x-slot name="header">
        {{ __('Send Message') }}
    </x-slot>

    <!-- Send Message Form -->
    <div class="max-w-xl">
        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl shadow-sm border border-secondary-200 dark:border-secondary-700">
            <!-- Form Content -->
            <form method="POST" class="p-4" action="{{ route('send.message') }}">
                @csrf
                <div class="mb-2">
                    <x-input-label for="phone" :value="__('Nomor Whatsapp')" required />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-900 dark:text-white">+62</span>
                        </div>
                        <x-text-input id="phone" name="phone" class="pl-12 pr-4" type="number" :value="old('phone')"
                            placeholder="85909090900" required autofocus autocomplete="phone" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <!-- Message Field -->
                <div class="mb-2">
                    <x-input-label for="message" :value="__('Pesan')" required />
                    <x-textarea id="message" name="message" rows="6" placeholder="Tulis pesan kamu disini..."
                        required />
                    <x-input-error :messages="$errors->get('message')" class="mt-1" />
                </div>

                <!-- Form Actions -->
                <div
                    class="flex items-center justify-end pt-6 border-t border-secondary-200 dark:border-secondary-700 space-x-3">
                    <x-secondary-button>Batal</x-secondary-button>
                    <x-primary-button>Kirim</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
