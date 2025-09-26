<x-app-layout>
    <x-slot name="header">
        {{ __('Kontak') }}
    </x-slot>

    <div class="w-full flex flex-col lg:flex-row gap-6">

        {{-- FORM ADD --}}
        <div class="w-full lg:w-96 shrink-0 order-1 lg:order-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-secondary-200 shadow-md dark:border-secondary-700">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-5 text-gray-900 dark:text-gray-100">Tambah Kontak Baru</h2>
                    <form action="{{ route('contacts.store') }}" method="post" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Name" required />
                            <x-text-input id="name" name="name" type="text" class="w-full" placeholder="Masukan Nama..." required />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="phone" value="Phone" required />
                            <x-text-input id="phone" name="phone" type="number" class="w-full" placeholder="Masukan Nomor Telepon..." required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                        </div>
                        <div class="flex">
                           <x-primary-button type="submit" class="ms-auto px-6">SIMPAN</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TABLE CONTACT --}}
        <div class="flex-1 order-2 lg:order-1">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-secondary-200 shadow-md dark:border-secondary-700 overflow-x-auto">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Kontak</h2>
                    <button onclick="openImportModal()"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg shadow">
                        Import Excel
                    </button>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-center">
                                <th scope="col" class="py-3">NO</th>
                                <th scope="col" class="py-3">NAME</th>
                                <th scope="col" class="py-3">PHONE</th>
                                <th scope="col" class="py-3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $key => $c)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 
                                           hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
                                    <th
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $contacts->perPage() * ($contacts->currentPage() - 1) + $key + 1 }}
                                    </th>
                                    <td class="text-left px-3 py-4 w-full">{{ $c->name }}</td>
                                    <td class="px-6 py-4">{{ $c->phone }}</td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <button type="button" data-id="{{ $c->id }}"
                                            data-nama="{{ $c->name }}" data-phone="{{ $c->phone }}"
                                            onclick="editContactModal(this)"
                                            class="px-3 py-1 text-xs text-white rounded-md bg-amber-500 hover:bg-amber-600">
                                            Edit
                                        </button>
                                        <form action="{{ route('contacts.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kontak: {{ $c->name }} ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs text-white rounded-md bg-red-500 hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Import --}}
    <div id="importModal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Import Kontak dari Excel</h3>
            <form action="{{ route('contacts.import.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input type="file" name="file" required
                        class="block w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer focus:outline-none dark:text-gray-100">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeImportModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg text-sm dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UPDATE CONTACT --}}
    <div id="contactModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/50 transition">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 transform transition-all scale-95 animate-fade-in">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Update Contact</h3>

            <form id="updateContactForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Name</label>
                    <input id="updateName" name="name" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                               dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukan Nama..." required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Phone</label>
                    <input id="updatePhone" name="phone" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                               dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                               dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukan Nomor Telepon..." required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeContactModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg text-sm
                               dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editContactModal(button) {
            let id = button.getAttribute("data-id");
            let name = button.getAttribute("data-nama");
            let phone = button.getAttribute("data-phone");

            document.getElementById("updateName").value = name;
            document.getElementById("updatePhone").value = phone;

            let form = document.getElementById("updateContactForm");
            form.action = "/contacts/" + id;

            document.getElementById("contactModal").classList.remove("hidden");
        }

        function closeContactModal() {
            document.getElementById("contactModal").classList.add("hidden");
        }

        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
            document.getElementById('importModal').classList.add('flex');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.getElementById('importModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
