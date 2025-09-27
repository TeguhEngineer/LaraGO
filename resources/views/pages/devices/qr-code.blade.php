<div class="text-center py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-secondary-900 dark:text-white mb-2">
            Koneksikan WhatsApp
        </h2>
        <p class="text-secondary-600 dark:text-secondary-400">
            Scan QR code berikut untuk menghubungkan akun WhatsApp Anda
        </p>
    </div>

    @if (isset($qrData) && $qrData['code'] === 'SUCCESS')
        <div id="qr-container"
            class="mb-6 inline-block p-4 bg-white dark:bg-secondary-700 rounded-lg border border-secondary-300 dark:border-secondary-600 transition-all duration-300">
            <img src="{{ $qrData['results']['qr_link'] }}" alt="WhatsApp QR Code" id="qr-image"
                class="mx-auto transition-all duration-300 rounded-lg" style="width: 256px; height: 256px;">
        </div>

        <div class="mb-6 space-y-2">
            <p id="qr-countdown" class="text-sm text-secondary-500 dark:text-secondary-400 font-medium">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    QR Code akan expired dalam <span class="font-bold text-orange-600">{{ $qrData['results']['qr_duration'] }}</span> detik
                </span>
            </p>
            <p id="qr-status" class="text-sm text-blue-500 dark:text-blue-400 mt-1 min-h-[1rem]"></p>
        </div>

        <div class="flex justify-center gap-4 mb-6">
            <button onclick="refreshQRCode()" id="refresh-btn"
                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh QR Code
            </button>
        </div>

        <div class="border-t border-secondary-200 dark:border-secondary-600 pt-6">
            <p class="text-sm text-secondary-500 dark:text-secondary-400 mb-3">
                Setelah scan QR code, klik tombol di bawah untuk mengecek status
            </p>
            <button onclick="checkStatus()" id="check-status-btn"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="status-text">Cek Status Koneksi</span>
            </button>
        </div>
    @else
        <div
            class="bg-yellow-100 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 p-4 rounded-lg mb-6">
            <p class="font-medium">Gagal generate QR Code</p>
            <p class="text-sm mt-1">{{ $qrData['message'] ?? 'Silakan refresh halaman' }}</p>
            @if (isset($qrData['status']))
                <p class="text-xs mt-1">Status: {{ $qrData['status'] }}</p>
            @endif
        </div>

        <button onclick="window.location.reload()"
            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
            Refresh Halaman
        </button>
    @endif

    <div class="mt-8 text-xs text-secondary-500 dark:text-secondary-400">
        <p>Pastikan WhatsApp di smartphone Anda sudah terinstall dan terkoneksi internet</p>
    </div>
</div>
