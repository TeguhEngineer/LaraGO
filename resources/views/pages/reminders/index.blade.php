<x-app-layout>
    <x-slot name="header">
        {{ __('Jadwal Pesan') }}
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css" />
    @endpush

    <div class="w-full flex flex-col lg:flex-row gap-6">
        {{-- Form Input (atas di mobile, kanan di desktop) --}}
        <div class="w-full lg:w-96 shrink-0 order-1 lg:order-2">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-secondary-200 shadow-md dark:border-secondary-700">
                <form method="POST" class="p-4" action="{{ route('reminders.store') }}">
                    @csrf
                    <div class="mb-2">
                        <x-input-label for="contact_id" :value="__('Pilih Kontak')" required />
                        <x-select-input id="contact_id" name="contact_id" placeholder="-- Pilih Kontak --"
                            selected="{{ old('contact_id') }}">
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}"
                                    {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                                    {{ $contact->name }} - ({{ $contact->phone }})
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('contact_id')" class="mt-1" />
                    </div>

                    <div class="mb-2">
                        <x-input-label for="title" value="Judul" required />
                        <x-text-input id="title" name="title" type="text" class="w-full"
                            placeholder="Tulis judul disini..." required />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <div class="mb-2">
                        <x-input-label for="description" value="Deskripsi" required />
                        <x-textarea id="description" name="description" rows="6"
                            placeholder="Tulis pesan kamu disini..." required />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="mb-2">
                        <x-input-label for="reminder_at" value="Jadwal" required />
                        <x-text-input id="reminder_at" name="reminder_at" type="datetime-local" class="w-full"
                            required />
                        <x-input-error :messages="$errors->get('reminder_at')" class="mt-1" />
                    </div>

                    <hr class="mb-2">
                    <div class="flex">
                        <x-primary-button type="submit" class="ms-auto px-6">Buat</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- List Reminder (bawah di mobile, kiri di desktop) --}}
        <div class="flex-1 order-2 lg:order-1">
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg border border-secondary-200 shadow-md dark:border-secondary-700 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="reminders-table">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">No</th>
                            <th scope="col" class="px-6 py-3 text-center">Nama</th>
                            <th scope="col" class="px-6 py-3 text-center">Judul</th>
                            <th scope="col" class="px-6 py-3 text-center">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 text-center">Waktu</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
        <script>
            $(document).ready(function() {
                $('#reminders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('reminders.data') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'contact.name',
                            name: 'contact.name'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'reminder_at',
                            name: 'reminder_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush

</x-app-layout>
