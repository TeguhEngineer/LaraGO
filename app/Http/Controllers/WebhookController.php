<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Simpan dulu payload untuk dicek strukturnya
        Log::info('GOWA Webhook', $request->all());

        // Contoh payload biasanya ada field "message" atau "text"
        $message = $request->input('message');
        $sender  = $request->input('sender');

        // Simple auto-reply kalau ada keyword
        if ($message && stripos($message, 'halo') !== false) {
            $this->sendReply($sender, "Hai juga 👋 dari Laravel!");
        }

        return response()->json(['status' => 'ok']);
    }

    private function sendReply($to, $text)
    {
        $url = env('GOWA_URL') . '/send/message';
        // $token = env('GOWA_API_TOKEN');

        $client = new \GuzzleHttp\Client();
        $client->post($url, [
            'headers' => [
                // 'Authorization' => "Bearer $token",
                'Accept'        => 'application/json',
            ],
            'form_params' => [
                'to'      => $to,
                'message' => $text,
            ]
        ]);
    }
}
