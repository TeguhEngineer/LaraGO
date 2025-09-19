<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $baseUrl;
    // protected $username;
    // protected $password;

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
}
