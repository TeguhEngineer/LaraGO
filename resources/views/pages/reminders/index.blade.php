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
                        <x-input-label for="user_id" :value="__('Pilih Kontak')" required />
                        <x-select-input id="user_id" name="user_id" placeholder="-- Pilih Kontak --"
                            selected="{{ old('user_id') }}">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - ({{ $user->phone }})
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
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
                {{-- Top bar: Select per page & Search --}}
                <div class="mb-4 flex justify-between items-center gap-4 flex-wrap">
                    {{-- Select per page --}}
                    <form method="GET" action="{{ route('reminders.index') }}">
                        <select id="per_page" name="per_page"
                            class="w-20 pl-2 pr-2 py-2 border border-gray-200 dark:border-gray-600 rounded shadow-sm focus:outline-none focus:border-primary-400 dark:focus:border-primary-400 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>

                    {{-- Search form --}}
                    <form method="GET" action="{{ route('reminders.index') }}" class="flex items-center gap-2">
                        <input type="text" name="search" id="search" placeholder="Cari reminder..."
                            value="{{ request('search') }}"
                            class="w-64 pl-2 pr-2 py-2 border border-gray-200 dark:border-gray-600 rounded shadow-sm focus:outline-none focus:border-primary-400 dark:focus:border-primary-400 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
                        <button type="submit"
                            class="px-4 py-2 bg-primary-500 text-white rounded shadow hover:bg-primary-600 focus:outline-none">
                            Cari
                        </button>
                    </form>
                </div>
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr
                            class="text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 uppercase text-center text-base">
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Pesan</th>
                            <th class="px-4 py-2">Waktu</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-400">
                        @forelse ($reminders as $index => $reminder)
                            <tr
                                class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $reminder->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $reminder->title }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $reminder->description }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    {{ \Carbon\Carbon::parse($reminder->reminder_at)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if ($reminder->status === 'pending')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-600/30 dark:text-yellow-300">
                                            Pending
                                        </span>
                                    @elseif ($reminder->status === 'send')
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-600/30 dark:text-green-300">
                                            Terkirim
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600/30 dark:text-gray-300">
                                            {{ ucfirst($reminder->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex items-center justify-center gap-2">
                                    <x-warning-button type="button">
                                        Edit
                                    </x-warning-button>
                                    <x-danger-button type="button">
                                        Delete
                                    </x-danger-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                    Reminder not found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">

                    {{ $reminders->links() }}
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
