<x-app-layout>
    <x-slot name="header">
        {{ __('Kirim Pesan') }}
    </x-slot>

    <!-- Send Message Form -->
    <div class="max-w-xl">
        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl shadow-sm border border-secondary-200 dark:border-secondary-700">
            <!-- Form Content -->
            <form method="POST" class="p-4" action="{{ route('send.message') }}" enctype="multipart/form-data">
                @csrf
                {{-- Phone Field --}}
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

                <!-- Image Field -->
                <div class="mb-2">
                    <x-input-label for="image" :value="__('Gambar (Max: 5MB)')" />
                    <x-text-input id="image" name="image" type="file" accept="image/*"
                        onchange="previewImage(event)" />
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />

                    <!-- Preview -->
                    <div class="mt-3 border flex justify-center">
                        <img id="imagePreview" src="#" alt="Preview Gambar"
                            class="hidden w-48 rounded-lg border border-gray-300 shadow" />
                    </div>
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


    @push('scripts')
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                const file = input.files[0];

                if (file) {
                    // Validasi ukuran file (max 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB dalam byte
                    if (file.size > maxSize) {
                        alert("⚠️ Ukuran gambar tidak boleh lebih dari 5MB!");
                        input.value = ""; // reset input
                        preview.src = "#";
                        preview.classList.add("hidden");
                        return;
                    }

                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove("hidden");
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
</x-app-layout>
