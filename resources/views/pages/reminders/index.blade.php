<x-app-layout>
    <x-slot name="header">
        {{ __('Jadwal Pesan') }}
    </x-slot>

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

        {{-- List Reminder --}}
        <div class="flex-1 order-2 lg:order-1">
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-secondary-200 shadow-md dark:border-secondary-700">
                <div class="overflow-x-auto">
                    <table id="reminders-table"
                        class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse">
                        <thead class="text-sm uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-center font-bold">No</th>
                                <th class="px-6 py-3 text-center">Nama</th>
                                <th class="px-6 py-3 text-center">Judul</th>
                                <th class="px-6 py-3 text-center">Deskripsi</th>
                                <th class="px-6 py-3 text-center">Waktu</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>

        <script>
            $(document).ready(function() {
                let table = $('#reminders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('reminders.data') }}',
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: "text-center"
                        },
                        {
                            data: 'contact.name',
                            name: 'contact.name',
                            className: "text-center"
                        },
                        {
                            data: 'title',
                            name: 'title',
                            className: "text-center"
                        },
                        {
                            data: 'description',
                            name: 'description',
                            className: "whitespace-normal text-center",
                            width: '30%'
                        },
                        {
                            data: 'reminder_at',
                            name: 'reminder_at',
                            className: "text-center"
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: "text-center"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: "text-center"
                        }
                    ],
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari data...",
                        lengthMenu: "_MENU_ entries per halaman",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    },
                    initComplete: function() {
                        // Search input
                        $('.dataTables_filter input')
                            .addClass(
                                'px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500'
                            );

                        // Length select
                        $('.dataTables_length select')
                            .addClass(
                                'px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500'
                            );

                        // Pagination
                        $('.dataTables_paginate')
                            .addClass('flex items-center space-x-2 mt-4');
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
