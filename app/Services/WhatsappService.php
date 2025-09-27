<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl  = config('services.gowa.url');
        $this->username = config('services.gowa.username');
        $this->password = config('services.gowa.password');
        $this->timeout  = config('services.gowa.timeout', 30);
    }

    /**
     * Get HTTP client with basic auth
     */
    private function getHttpClient()
    {
        return Http::timeout($this->timeout)
            ->withBasicAuth($this->username, $this->password);
    }

    /**
     * Generate QR Code untuk login
     */
    public function login()
    {
        try {
            $response = $this->getHttpClient()
                ->get($this->baseUrl . '/app/login');

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal generate QR code',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('Login Exception', [
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Reconnect WhatsApp
     */
    public function reconnect()
    {
        try {
            $response = $this->getHttpClient()
                ->get($this->baseUrl . '/app/reconnect');

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal reconnect',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('Reconnect Exception', [
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Logout dari WhatsApp
     */
    public function logout()
    {
        try {
            $response = $this->getHttpClient()
                ->get($this->baseUrl . '/app/logout');

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal logout',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('Logout Exception', [
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Get list devices
     */
    public function getDevices()
    {
        try {
            $response = $this->getHttpClient()
                ->get($this->baseUrl . '/app/devices');

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal get devices',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('GetDevices Exception', [
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Send text message
     */
    public function sendMessage($phone, $message, $replyMessageId = null, $isForwarded = false, $duration = 3600)
    {
        try {
            $payload = [
                'phone' => $phone,
                'message' => $message,
                'is_forwarded' => $isForwarded,
                'duration' => $duration
            ];

            if ($replyMessageId) {
                $payload['reply_message_id'] = $replyMessageId;
            }

            $response = $this->getHttpClient()
                ->post($this->baseUrl . '/send/message', $payload);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal mengirim pesan',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('SendMessage Exception', [
                'phone' => $phone,
                'message' => $message,
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Send image message
     */
    public function sendImage($phone, $imageUrl = null, $caption = null, $viewOnce = false, $compress = false, $isForwarded = false, $duration = 3600, $imageFile = null)
    {
        try {
            $payload = [
                'phone' => $phone,
                'caption' => $caption,
                'view_once' => $viewOnce,
                'compress' => $compress,
                'is_forwarded' => $isForwarded,
                'duration' => $duration
            ];

            if ($imageUrl) {
                $payload['image_url'] = $imageUrl;
            }

            // Jika ada file gambar, gunakan multipart form data
            if ($imageFile) {
                $response = $this->getHttpClient()
                    ->attach('image', $imageFile, 'image.jpg')
                    ->post($this->baseUrl . '/send/image', $payload);
            } else {
                $response = $this->getHttpClient()
                    ->post($this->baseUrl . '/send/image', $payload);
            }

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal mengirim gambar',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('SendImage Exception', [
                'phone' => $phone,
                'image_url' => $imageUrl,
                'caption' => $caption,
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Send file message
     */
    public function sendFile($phone, $file, $caption = null, $originalFileName = null, $isForwarded = false, $duration = 3600)
    {
        try {
            // Pastikan file exists
            if (!file_exists($file)) {
                throw new \Exception("File tidak ditemukan: {$file}");
            }

            $payload = [
                'phone' => $phone,
                'caption' => $caption,
                'is_forwarded' => $isForwarded,
                'duration' => $duration
            ];

            // Debug log
            Log::info('SendFile Debug', [
                'phone' => $phone,
                'file_path' => $file,
                'original_filename' => $originalFileName,
                'final_filename' => $originalFileName ?: basename($file),
                'file_exists' => file_exists($file),
                'file_size' => file_exists($file) ? filesize($file) : 'N/A',
                'mime_type' => file_exists($file) ? mime_content_type($file) : 'N/A',
                'payload' => $payload
            ]);

            // Baca file content dan kirim sebagai attachment
            $fileContent = file_get_contents($file);
            if ($fileContent === false) {
                throw new \Exception("Tidak dapat membaca konten file: {$file}");
            }

            // Gunakan nama file asli jika disediakan, jika tidak gunakan basename dari path
            $fileName = $originalFileName ?: basename($file);
            
            $response = $this->getHttpClient()
                ->attach('file', $fileContent, $fileName)
                ->post($this->baseUrl . '/send/file', $payload);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Gagal mengirim file',
                'data' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::error('SendFile Exception', [
                'phone' => $phone,
                'file' => $file,
                'caption' => $caption,
                'error' => $th->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
