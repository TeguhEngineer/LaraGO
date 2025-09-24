<div class="user-info">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-secondary-200 dark:border-secondary-700">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900 dark:text-white">
                Perangkat Terkoneksi
            </h2>
            <p class="text-secondary-600 dark:text-secondary-400 mt-1">
                WhatsApp Anda sudah terhubung dengan sistem
            </p>
        </div>
        <form action="{{ route('devices.logout') }}" method="POST" class="flex-shrink-0">
            @csrf
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin logout dari WhatsApp?')"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    {{-- Info Perangkat --}}
    <div class="space-y-4">
        @foreach ($devicesInfo as $index => $device)
            <div
                class="bg-secondary-50 dark:bg-secondary-700 border border-secondary-200 dark:border-secondary-600 p-6 rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-secondary-900 dark:text-white">
                                {{ $device['name'] ?: 'Unknown Name' }}
                            </h3>
                            <p class="text-secondary-600 dark:text-secondary-400 text-sm">
                                Terhubung
                            </p>
                        </div>
                    </div>
                    <span
                        class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full text-sm font-medium">
                        Aktif
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-secondary-700 dark:text-secondary-300">Nama:</span>
                        <span
                            class="text-secondary-900 dark:text-white ml-2">{{ $device['name'] ?: 'Tidak tersedia' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-secondary-700 dark:text-secondary-300">Device ID:</span>
                        <span
                            class="text-secondary-900 dark:text-white ml-2 font-mono text-xs">{{ $device['device'] }}</span>
                    </div>
                </div>

                {{-- Extract info dari device string --}}
                @php
                    $deviceInfo = parseDeviceInfo($device['device']);
                @endphp

                @if ($deviceInfo)
                    <div
                        class="mt-4 pt-4 border-t border-secondary-200 dark:border-secondary-600 grid md:grid-cols-2 gap-4 text-xs">
                        @if ($deviceInfo['phone_number'])
                            <div>
                                <span class="font-medium text-secondary-700 dark:text-secondary-300">Nomor
                                    Telepon:</span>
                                <span
                                    class="text-secondary-900 dark:text-white ml-2">{{ $deviceInfo['phone_number'] }}</span>
                            </div>
                        @endif

                        @if ($deviceInfo['device_id'])
                            <div>
                                <span class="font-medium text-secondary-700 dark:text-secondary-300">Device ID:</span>
                                <span
                                    class="text-secondary-900 dark:text-white ml-2">{{ $deviceInfo['device_id'] }}</span>
                            </div>
                        @endif

                        @if ($deviceInfo['server'])
                            <div>
                                <span class="font-medium text-secondary-700 dark:text-secondary-300">Server:</span>
                                <span class="text-secondary-900 dark:text-white ml-2">{{ $deviceInfo['server'] }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Empty state --}}
    @if (empty($devicesInfo))
        <div class="text-center py-8">
            <div
                class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-secondary-900 dark:text-white mb-2">Tidak ada perangkat</h3>
            <p class="text-secondary-600 dark:text-secondary-400">Tidak ada perangkat WhatsApp yang terkoneksi</p>
        </div>
    @endif
</div>

<?php
// Helper function untuk parse device information
function parseDeviceInfo($deviceString)
{
    try {
        $parts = explode('@', $deviceString);
        if (count($parts) !== 2) {
            return null;
        }

        $userPart = $parts[0];
        $serverPart = $parts[1];

        // Parse phone number dan device ID
        $userParts = explode(':', $userPart);
        $phoneNumber = $userParts[0] ?? null;
        $deviceId = $userParts[1] ?? null;

        return [
            'phone_number' => $phoneNumber,
            'device_id' => $deviceId,
            'server' => $serverPart,
            'full_string' => $deviceString,
        ];
    } catch (\Exception $e) {
        return null;
    }
}
?>
