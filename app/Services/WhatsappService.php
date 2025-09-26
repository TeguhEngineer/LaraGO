<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl  = config('services.gowa.url');
    }

    public function sendMessage($phone, $message)
    {
        try {
            $request = Http::post("{$this->baseUrl}/send/message", [
                'phone'   => $phone,
                'message' => $message,
            ]);

            if ($request->successful()) {
                return [
                    'status'  => true,
                    'data'    => $request->json(),
                ];
            }

            return [
                'status'  => false,
                'message' => $request->json('message') ?? 'Gagal mengirim pesan',
            ];
        } catch (\Throwable $th) {
            Log::error('SendMessage Exception', [
                'phone' => $phone,
                'message' => $message,
                'error' => $th->getMessage(),
            ]);

            return [
                'status'  => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    public function sendImage($phone, $imageUrl, $caption = null)
    {
        try {
            $request = Http::post("{$this->baseUrl}/send/image", [
                'phone'   => $phone,
                'image_url'  => $imageUrl,   // 👈 kirim URL, bukan binary file
                'caption' => $caption,
            ]);

            if ($request->successful()) {
                return [
                    'status' => true,
                    'data'   => $request->json(),
                ];
            }

            return [
                'status'  => false,
                'message' => $request->json('message') ?? 'Gagal mengirim gambar',
            ];
        } catch (\Throwable $th) {
            Log::error('SendImage Exception', [
                'phone' => $phone,
                'image_url' => $imageUrl,
                'caption' => $caption,
                'error' => $th->getMessage(),
            ]);

            return [
                'status'  => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
