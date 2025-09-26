<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendMultiTypeMessageController extends Controller
{
    protected $wa;

    public function __construct(WhatsAppService $wa)
    {
        $this->wa = $wa;
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'phone'      => 'required|digits_between:9,15',
            'message' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ], [
            '*.required' => 'Kolom inputan ini harus diisi.',
            'phone.digits_between' => 'Nomor WhatsApp harus antara 9 sampai 15 digit.',
            'message.max'   => 'Pesan maksimal 500 karakter.',
            'image.max'     => 'Ukuran gambar maksimal 5MB.',
            'image.mimes'   => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.image'   => 'File yang diunggah bukan gambar.',
        ]);

        $skip = ltrim($validated['phone'], '0'); // buang 0 di depan kalau ada
        $phone = '62' . $skip;

        try {

            if ($request->hasFile('image')) {
                // ✅ Kirim gambar dengan caption
                $path = $request->file('image')->store('uploads', 'public');
                $imageUrl = asset(str_replace('public', 'storage', $path)); // buat URL public

                $result = $this->wa->sendImage($phone, $imageUrl, $validated['message'] ?? '');
            } else {
                // ✅ Kirim pesan teks biasa
                $result = $this->wa->sendMessage($phone, $validated['message']);
            }

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
            Log::error("Error saat mengirim pesan (API): " . $th->getMessage());
        }
    }
}
