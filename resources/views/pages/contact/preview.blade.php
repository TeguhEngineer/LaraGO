{{-- resources/views/contacts/import-preview.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Preview Import Kontak') }}
    </x-slot>

    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-xl shadow">
                        <h3 class="text-lg font-semibold mb-5">Preview Data Import</h3>
                        
                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-800 dark:text-green-200">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg dark:bg-red-800 dark:text-red-200">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('contacts.import.confirm') }}" method="POST">
                            @csrf
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr class="text-center">
                                            <th scope="col" class="py-3">Pilih</th>
                                            <th scope="col" class="py-3">Nama</th>
                                            <th scope="col" class="py-3">Phone</th>
                                            <th scope="col" class="py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($temps as $c)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
                                                <td class="px-6 py-4">
                                                    @if($c->is_valid)
                                                        <input type="checkbox" name="selected[]" value="{{ $c->id }}" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                                    @else
                                                        <input type="checkbox" name="selected[]" value="{{ $c->id }}" disabled class="w-4 h-4 text-gray-300 bg-gray-100 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">{{ $c->name ?? '-' }}</td>
                                                <td class="px-6 py-4">{{ $c->phone ?? '-' }}</td>
                                                <td class="px-6 py-4">
                                                    @if($c->is_valid)
                                                        <span class="text-green-600 dark:text-green-400">✅ Valid</span>
                                                    @else
                                                        <span class="text-red-600 dark:text-red-400">❌ Invalid: {{ implode(', ', json_decode($c->error_messages, true) ?? []) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                    Tidak ada data untuk ditampilkan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <a href="{{ route('contacts.index') }}"
                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg text-sm dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">
                                    Kembali
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    @if($temps->where('is_valid', true)->isEmpty()) disabled @endif>
                                    Import Data Terpilih
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>