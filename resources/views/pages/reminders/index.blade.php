<x-app-layout>
    <x-slot name="header">
        {{ __('Jadwal Pesan') }}
    </x-slot>

    {{-- Full Width Table Container --}}
    <div class="w-full" x-data="{ modalOpen: false }">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-secondary-200 dark:border-secondary-700">

            {{-- Custom DataTables Header --}}
            <div class="mb-6">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Daftar Jadwal Pesan</h2>
                    <x-primary-button @click="modalOpen = true" class="ml-auto">Tambah Jadwal Pesan</x-primary-button>
                </div>

                {{-- Search and Length Controls --}}
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Tampilkan</label>
                        <select id="custom-length"
                            class="px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent min-w-[60px]">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap hidden sm:block">data
                            per
                            halaman</label>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Cari:</label>
                        <input type="text" id="custom-search" placeholder="Ketik untuk mencari..."
                            class="px-4 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-primary-500 focus:border-transparent w-full sm:w-64">
                    </div>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="overflow-x-auto" id="table-wrapper">
                <table id="reminders-table"
                    class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600">
                                No</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600">
                                Nama</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600">
                                Judul</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600">
                                Deskripsi</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600">
                                Waktu</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">
                                Status</th>
                            <th
                                class="px-4 py-3 text-center font-semibold border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Skeleton Loading Rows --}}
                        <tr id="skeleton-row-1" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-16 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-2" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-20 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-3" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-18 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-4" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/5"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-16 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-5" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-20 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-6" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-20 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>
                        <tr id="skeleton-row-7" class="skeleton-row">
                            <td class="px-4 py-4 text-center">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-4/5"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-2/3"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-5/6"></div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-3/4"></div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-full animate-pulse w-20 mx-auto">
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-12"></div>
                                    <div class="h-7 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-14"></div>
                                </div>
                            </td>
                        </tr>

                        {{-- Simple Loading indicator row (backup) --}}
                        <tr id="loading-row" class="hidden">
                            <td colspan="7" class="px-4 py-8 text-center">
                                <div class="flex items-center justify-center">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                    <span class="ml-3 text-gray-600 dark:text-gray-400">Memuat data...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 gap-4">
                <div id="table-info" class="text-sm text-gray-700 dark:text-gray-300"></div>
                <div id="table-pagination" class="flex items-center space-x-2"></div>
            </div>
        </div>

        {{-- Modal Form --}}
        <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="modalOpen = false"></div>

            {{-- Modal Content --}}
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">

                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Tambah Jadwal Pesan Baru
                        </h3>
                        <button @click="modalOpen = false"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Form --}}
                    <form method="POST" action="{{ route('reminders.store') }}" class="space-y-4">
                        @csrf

                        {{-- Contact Selection --}}
                        <div>
                            <x-input-label for="modal_contact_id" :value="__('Pilih Kontak')" required />
                            <x-select-input id="modal_contact_id" name="contact_id" placeholder="-- Pilih Kontak --"
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

                        {{-- Title --}}
                        <div>
                            <x-input-label for="modal_title" value="Judul" required />
                            <x-text-input id="modal_title" name="title" type="text" class="w-full"
                                placeholder="Tulis judul disini..." required value="{{ old('title') }}" />
                            <x-input-error :messages="$errors->get('title')" class="mt-1" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="modal_description" value="Deskripsi" required />
                            <x-textarea id="modal_description" name="description" rows="4"
                                placeholder="Tulis pesan kamu disini..." required>{{ old('description') }}</x-textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        {{-- Schedule --}}
                        <div>
                            <x-input-label for="modal_reminder_at" value="Jadwal" required />
                            <x-text-input id="modal_reminder_at" name="reminder_at" type="datetime-local"
                                class="w-full" required value="{{ old('reminder_at') }}" />
                            <x-input-error :messages="$errors->get('reminder_at')" class="mt-1" />
                        </div>

                        {{-- Modal Actions --}}
                        <div class="flex items-center justify-end space-x-3 pt-4">
                            <x-secondary-button type="button" @click="modalOpen = false">
                                Batal
                            </x-secondary-button>
                            <x-primary-button type="submit" class="px-6">
                                Buat Jadwal
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Auto-open modal if there are validation errors
                @if ($errors->any())
                    // Use Alpine.js to open modal
                    setTimeout(function() {
                        const alpineData = Alpine.$data(document.querySelector('[x-data]'));
                        if (alpineData) {
                            alpineData.modalOpen = true;
                        }
                    }, 100);
                @endif
                let table = $('#reminders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('reminders.data') }}',
                        beforeSend: function() {
                            // Show skeleton loading
                            showLoading();
                        },
                        complete: function() {
                            // Hide skeleton loading
                            hideLoading();
                        },
                        error: function(xhr, error, code) {
                            console.error('DataTables Ajax Error:', {
                                xhr: xhr,
                                error: error,
                                code: code,
                                responseText: xhr.responseText
                            });

                            // Hide loading and show error
                            hideLoading();
                            alert(
                                'Terjadi kesalahan saat memuat data. Silakan refresh halaman atau hubungi administrator.'
                            );
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            className: "px-4 py-3 text-center text-sm font-medium text-gray-900 dark:text-gray-100",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'contact_name',
                            name: 'contact.name',
                            className: "px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-300"
                        },
                        {
                            data: 'title',
                            name: 'title',
                            className: "px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-300"
                        },
                        {
                            data: 'description',
                            name: 'description',
                            className: "px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-300",
                            width: '30%',
                            render: function(data, type, row) {
                                if (data && data.length > 50) {
                                    return '<div class="max-w-xs truncate" title="' + data + '">' + data
                                        .substring(0, 50) + '...</div>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'reminder_at',
                            name: 'reminder_at',
                            className: "px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-300",
                            render: function(data, type, row) {
                                if (data) {
                                    let date = new Date(data);
                                    return date.toLocaleDateString('id-ID', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                }
                                return '-';
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: "px-4 py-3 text-center text-sm",
                            render: function(data, type, row) {
                                let badgeClass = data === 'send' ?
                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 px-4' :
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' +
                                    badgeClass + '">' +
                                    (data === 'send' ? 'Selesai' : 'Menunggu') + '</span>';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: "px-4 py-3 text-center text-sm"
                        }
                    ],
                    dom: 'rt', // Only show table and processing
                    pageLength: 10,
                    responsive: true,
                    processing: false, // Disable default processing indicator
                    language: {
                        emptyTable: '<div class="text-center py-8 text-gray-500 dark:text-gray-400">Tidak ada data yang tersedia</div>',
                        zeroRecords: '<div class="text-center py-8 text-gray-500 dark:text-gray-400">Tidak ada data yang cocok dengan pencarian</div>'
                    },
                    drawCallback: function(settings) {
                        // Hide skeleton after data is drawn
                        hideInitialSkeleton();
                        updateTableInfo(settings);
                        updatePagination(settings);
                    },
                    initComplete: function() {
                        // Hide skeleton after initial load
                        hideInitialSkeleton();
                    }
                });

                // Simple and stable responsive handling
                let resizeTimer;

                function adjustTableColumns() {
                    if (table) {
                        table.columns.adjust();
                    }
                }

                // Only handle window resize - no flicker
                $(window).on('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(adjustTableColumns, 200);
                });

                // Custom search functionality
                $('#custom-search').on('keyup', function() {
                    showLoading();
                    table.search(this.value).draw();
                });

                // Custom length functionality
                $('#custom-length').on('change', function() {
                    showLoading();
                    table.page.len(parseInt(this.value)).draw();
                });

                // Loading functions
                function showLoading() {
                    // Show skeleton rows, hide data rows
                    $('.skeleton-row').removeClass('hidden');
                    $('#reminders-table tbody tr:not(.skeleton-row):not(#loading-row)').addClass('hidden');
                    $('#loading-row').addClass('hidden');
                }

                function hideLoading() {
                    // Hide skeleton rows, show data rows
                    $('.skeleton-row').addClass('hidden');
                    $('#reminders-table tbody tr:not(.skeleton-row):not(#loading-row)').removeClass('hidden');
                    $('#loading-row').addClass('hidden');
                }

                function showInitialSkeleton() {
                    // Show skeleton on initial load
                    $('.skeleton-row').removeClass('hidden');
                    $('#loading-row').addClass('hidden');
                }

                function hideInitialSkeleton() {
                    // Hide skeleton after initial load
                    $('.skeleton-row').addClass('hidden');
                }

                // Update table info
                function updateTableInfo(settings) {
                    let api = new $.fn.dataTable.Api(settings);
                    let info = api.page.info();
                    let infoText = '';

                    if (info.recordsTotal === 0) {
                        infoText = 'Menampilkan 0 dari 0 data';
                    } else {
                        infoText = `Menampilkan ${info.start + 1} sampai ${info.end} dari ${info.recordsTotal} data`;
                        if (info.recordsFiltered !== info.recordsTotal) {
                            infoText += ` (difilter dari ${info.recordsTotal} total data)`;
                        }
                    }

                    $('#table-info').html(infoText);
                }

                // Update pagination
                function updatePagination(settings) {
                    let api = new $.fn.dataTable.Api(settings);
                    let info = api.page.info();
                    let paginationHtml = '';

                    if (info.pages > 1) {
                        // Previous button
                        paginationHtml += `<button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${info.page === 0 ? 'cursor-not-allowed opacity-50' : ''}" 
                                          ${info.page === 0 ? 'disabled' : ''} onclick="showLoading(); table.page('previous').draw();">
                                          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        </button>`;

                        // Page numbers
                        let startPage = Math.max(0, info.page - 2);
                        let endPage = Math.min(info.pages - 1, info.page + 2);

                        for (let i = startPage; i <= endPage; i++) {
                            let isActive = i === info.page;
                            paginationHtml += `<button class="px-3 py-2 text-sm font-medium ${isActive ? 'text-blue-600 bg-blue-50 border border-blue-300 dark:bg-gray-700 dark:text-white' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'}" 
                                             onclick="showLoading(); table.page(${i}).draw();">
                                             ${i + 1}
                                           </button>`;
                        }

                        // Next button
                        paginationHtml += `<button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${info.page === info.pages - 1 ? 'cursor-not-allowed opacity-50' : ''}" 
                                          ${info.page === info.pages - 1 ? 'disabled' : ''} onclick="showLoading(); table.page('next').draw();">
                                          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                        </button>`;
                    }

                    $('#table-pagination').html(paginationHtml);
                }

                // Global function for delete confirmation
                window.confirmDelete = function(id, title) {
                    if (confirm(`Apakah Anda yakin ingin menghapus reminder "${title}"?`)) {
                        // Add your delete logic here
                        console.log('Deleting reminder with ID:', id);
                        // You can make an AJAX call to delete the reminder
                        // or redirect to a delete route
                    }
                }
            });
        </script>
    @endpush

</x-app-layout>
