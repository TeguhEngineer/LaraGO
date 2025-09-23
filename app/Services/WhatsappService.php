<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

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
                'image_url'     => $imageUrl,   // 👈 kirim URL, bukan binary file
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
            return [
                'status'  => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
