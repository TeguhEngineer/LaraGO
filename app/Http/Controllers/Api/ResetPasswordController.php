<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected $wa;

    public function __construct(WhatsAppService $wa)
    {
        $this->wa = $wa;
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'phone'      => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $result = $this->wa->sendMessage($validated['phone'], $validated['message']);

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'data'    => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error'   => $th->getMessage()
            ], 500);
        }
    }
}
