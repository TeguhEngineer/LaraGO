<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reminder Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form Tambah Reminder --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-6">
                <form method="POST" action="{{ route('reminders.store') }}">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="user_id">Select User</x-input-label>
                        <select name="user_id" id="user_id" class="w-full border-gray-300 rounded">
                            <option disabled selected>-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="w-full" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3"
                            class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="reminder_at" value="Remnider At" />
                        <x-text-input id="reminder_at" name="reminder_at" type="datetime-local" class="w-full"
                            required />
                    </div>

                    <x-primary-button type="submit">Create</x-primary-button>
                </form>
            </div>

            {{-- List Reminder --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4 text-gray-500 dark:text-gray-400">List Reminders</h3>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($reminders as $reminder)
                        <li class="py-3 flex justify-between items-center text-gray-500 dark:text-gray-400">
                            <div>
                                <p class="font-bold">{{ $reminder->title }}</p>
                                <p class="font-bold">{{ $reminder->description }}</p>
                                <p class="text-sm ">
                                    {{ $reminder->reminder_at }}
                                    ({{ ucfirst($reminder->status) }})
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="py-3 text-gray-500 dark:text-gray-400">Reminder not found.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
