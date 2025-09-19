<x-guest-layout>
    <form method="POST" action="{{ route('store.verify-otp') }}">
        @csrf
        @if (session('success'))
            <h1 class="text-green-600">{{ session('success') }}</h1>
        @endif
        @if (session('warning'))
            <h1 class="text-yellow-600">{{ session('warning') }}</h1>
        @endif

        <div>
            <x-input-label for="email" :value="__('Masukan kode OTP')" />
            <x-text-input id="otp" type="text" name="otp" class="mt-1 block w-full" :value="old('otp')" autofocus
                autocomplete="username" />
            @error('otp')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            @error('session_null')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            @error('otp_expired')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4 flex items-center justify-end">
            @if ($errors->has('session_null'))
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ms-2">
                    Register
                </a>
            @else
                <x-primary-button>Verifikasi</x-primary-button>
            @endif
        </div>
    </form>
    @error('otp_expired')
        <form action="{{ route('resend.otp') }}" method="POST">
            @csrf
            <x-danger-button class="mt-4 " type="submit" formaction="{{ route('resend.otp') }}">Kirim ulang
                kode OTP</x-danger-button>
        </form>
    @enderror
</x-guest-layout>
