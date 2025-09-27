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
            let countdownInterval = null;
            let statusCheckInterval = null;
            let currentQRSession = null;

            // Initialize when page loads
            document.addEventListener('DOMContentLoaded', function() {
                const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};
                
                if (!isLoggedIn) {
                    // Start countdown and status checking for QR code
                    @if(isset($qrData) && $qrData && $qrData['code'] === 'SUCCESS')
                        currentQRSession = {
                            generated_at: '{{ session('qr_session.generated_at') }}',
                            duration: {{ session('qr_session.duration', 30) }},
                            qr_link: '{{ session('qr_session.qr_link') }}'
                        };
                        startCountdown();
                    @endif
                    
                    // Start status checking
                    startStatusChecking();
                }
            });

            // Real-time countdown timer
            function startCountdown() {
                if (!currentQRSession) return;
                
                // Clear existing interval
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }
                
                countdownInterval = setInterval(function() {
                    const generatedAt = new Date(currentQRSession.generated_at).getTime();
                    const duration = currentQRSession.duration * 1000;
                    const now = new Date().getTime();
                    const remaining = duration - (now - generatedAt);
                    
                    const countdownElement = document.getElementById('qr-countdown');
                    
                    if (remaining > 0) {
                        const seconds = Math.floor(remaining / 1000);
                        if (countdownElement) {
                            countdownElement.innerHTML = `
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    QR Code akan expired dalam <span class="font-bold text-orange-600">${seconds}</span> detik
                                </span>
                            `;
                        }
                        
                        // Auto refresh when 5 seconds left
                        if (seconds <= 5 && seconds > 0) {
                            const qrImage = document.getElementById('qr-image');
                            if (qrImage) {
                                qrImage.classList.add('opacity-75', 'animate-pulse');
                            }
                        }
                    } else {
                        // QR expired, auto refresh
                        if (countdownElement) {
                            countdownElement.innerHTML = `
                                <span class="inline-flex items-center gap-2 text-red-600">
                                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    QR Code expired, generating new one...
                                </span>
                            `;
                        }
                        
                        clearInterval(countdownInterval);
                        refreshQRCode();
                    }
                }, 1000); // Update every second
            }

            // Initialize Server-Sent Events for real-time status updates
            let eventSource = null;
            
            function startStatusChecking() {
                // Try SSE first, fallback to polling if not supported
                if (typeof(EventSource) !== "undefined") {
                    initializeSSE();
                } else {
                    console.log('SSE not supported, using polling fallback');
                    startPollingFallback();
                }
            }

            function initializeSSE() {
                try {
                    eventSource = new EventSource('{{ route('devices.status-stream') }}');
                    
                    eventSource.onopen = function(event) {
                        console.log('SSE connection opened');
                        showStatusMessage('Monitoring status real-time...', 'info');
                    };
                    
                    eventSource.onmessage = function(event) {
                        console.log('SSE message received:', event.data);
                        const data = JSON.parse(event.data);
                        
                        if (data.isLoggedIn) {
                            // Stop all intervals and close SSE
                            if (countdownInterval) clearInterval(countdownInterval);
                            if (eventSource) {
                                eventSource.close();
                                eventSource = null;
                            }
                            
                            // Show success message and reload
                            showStatusMessage('Berhasil terhubung! Memuat ulang halaman...', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    };
                    
                    eventSource.onerror = function(event) {
                        console.error('SSE connection error:', event);
                        showStatusMessage('Connection error, switching to polling...', 'error');
                        
                        // Close SSE and fallback to polling
                        if (eventSource) {
                            eventSource.close();
                            eventSource = null;
                        }
                        
                        // Fallback to polling after 2 seconds
                        setTimeout(() => {
                            startPollingFallback();
                        }, 2000);
                    };
                    
                } catch (error) {
                    console.error('SSE initialization error:', error);
                    startPollingFallback();
                }
            }

            // Fallback polling method (original method)
            function startPollingFallback() {
                if (statusCheckInterval) {
                    clearInterval(statusCheckInterval);
                }
                
                statusCheckInterval = setInterval(function() {
                    checkLoginStatus();
                }, 3000); // Check every 3 seconds
            }

            // Check login status (for polling fallback)
            function checkLoginStatus() {
                fetch('{{ route('devices.status') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.isLoggedIn) {
                            // Stop all intervals
                            if (countdownInterval) clearInterval(countdownInterval);
                            if (statusCheckInterval) clearInterval(statusCheckInterval);
                            
                            // Show success message and reload
                            showStatusMessage('Berhasil terhubung! Memuat ulang halaman...', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Status check error:', error);
                    });
            }

            // Refresh QR Code via AJAX (tanpa reload halaman)
            function refreshQRCode() {
                const refreshBtn = document.getElementById('refresh-btn');
                const qrImage = document.getElementById('qr-image');
                const qrContainer = document.getElementById('qr-container');
                
                // Disable button and show loading
                if (refreshBtn) {
                    refreshBtn.disabled = true;
                    refreshBtn.innerHTML = `
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Generating...
                    `;
                }
                
                if (qrImage) {
                    qrImage.classList.add('opacity-50', 'animate-pulse');
                }
                
                // Clear existing countdown
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }
                
                fetch('{{ route('devices.generate-qr') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update QR image
                        if (qrImage) {
                            qrImage.src = data.data.results.qr_link;
                            qrImage.classList.remove('opacity-50', 'animate-pulse');
                        }
                        
                        // Update session data
                        currentQRSession = data.qr_session;
                        
                        // Restart countdown
                        startCountdown();
                        
                        showStatusMessage('QR Code berhasil di-refresh!', 'success');
                    } else {
                        showStatusMessage('Gagal refresh QR Code: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Refresh QR error:', error);
                    showStatusMessage('Error saat refresh QR Code', 'error');
                })
                .finally(() => {
                    // Re-enable button
                    if (refreshBtn) {
                        refreshBtn.disabled = false;
                        refreshBtn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh QR Code
                        `;
                    }
                    
                    if (qrImage) {
                        qrImage.classList.remove('opacity-50', 'animate-pulse');
                    }
                });
            }

            // Show status messages
            function showStatusMessage(message, type = 'info') {
                const statusElement = document.getElementById('qr-status');
                if (!statusElement) return;
                
                const colors = {
                    success: 'text-green-600 dark:text-green-400',
                    error: 'text-red-600 dark:text-red-400',
                    info: 'text-blue-600 dark:text-blue-400'
                };
                
                statusElement.className = `text-sm mt-1 ${colors[type] || colors.info}`;
                statusElement.textContent = message;
                
                // Clear message after 3 seconds
                setTimeout(() => {
                    if (statusElement) {
                        statusElement.textContent = '';
                    }
                }, 3000);
            }

            // Manual check status button
            function checkStatus() {
                const checkBtn = document.getElementById('check-status-btn');
                const statusText = document.getElementById('status-text');
                
                if (checkBtn) checkBtn.disabled = true;
                if (statusText) statusText.textContent = 'Mengecek...';
                
                checkLoginStatus();
                
                setTimeout(() => {
                    if (checkBtn) checkBtn.disabled = false;
                    if (statusText) statusText.textContent = 'Cek Status Koneksi';
                }, 2000);
            }

            // Cleanup intervals and SSE when page unloads
            window.addEventListener('beforeunload', function() {
                if (countdownInterval) clearInterval(countdownInterval);
                if (statusCheckInterval) clearInterval(statusCheckInterval);
                if (eventSource) {
                    eventSource.close();
                    eventSource = null;
                }
            });
        </script>
    @endpush
</x-app-layout>
