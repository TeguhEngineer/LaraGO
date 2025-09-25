<x-app-layout>
    <x-slot name="header">
        {{ __('Perangkat WhatsApp') }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl shadow-sm border border-secondary-200 dark:border-secondary-700 p-6">
            {{-- Status Alert --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Content berdasarkan status login --}}
            <div id="whatsapp-status">
                @if ($isLoggedIn)
                    {{-- Tampilan sudah login --}}
                    @include('pages.devices.user-info')
                @else
                    {{-- Tampilan belum login --}}
                    @include('pages.devices.qr-code')
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto refresh status setiap 3 detik
            function checkStatus() {
                fetch('{{ route('devices.status') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.isLoggedIn) {
                            // Reload halaman jika status berubah menjadi logged in
                            window.location.reload();
                        } else if (data.qrSession) {
                            // Update countdown QR code jika perlu
                            updateQRCountdown(data.qrSession);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Check status setiap 3 detik
            setInterval(checkStatus, 10000);

            // Optional: Countdown untuk QR code
            function updateQRCountdown(qrSession) {
                if (!qrSession) return;

                const generatedAt = new Date(qrSession.generated_at).getTime();
                const duration = qrSession.duration * 1000; // Convert to milliseconds
                const now = new Date().getTime();
                const remaining = duration - (now - generatedAt);

                const countdownElement = document.getElementById('qr-countdown');

                if (countdownElement && remaining > 0) {
                    const seconds = Math.floor(remaining / 1000);
                    countdownElement.textContent = `QR Code akan expired dalam ${seconds} detik`;
                } else if (remaining <= 0) {
                    // QR expired, reload untuk generate baru
                    window.location.reload();
                }
            }

            // Manual refresh QR code
            function refreshQRCode() {
                const refreshBtn = document.getElementById('refresh-btn');
                const qrImage = document.getElementById('qr-image');

                if (refreshBtn) refreshBtn.disabled = true;
                if (qrImage) qrImage.classList.add('opacity-50');

                fetch('{{ route('devices.index') }}')
                    .then(() => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (refreshBtn) refreshBtn.disabled = false;
                        if (qrImage) qrImage.classList.remove('opacity-50');
                    });
            }
        </script>
    @endpush
</x-app-layout>
