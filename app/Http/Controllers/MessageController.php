<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('pages.message.index');
    }

    public function send(Request $request, WhatsAppService $wa)
    {
        $validated = $request->validate([
            'phone' => 'required|digits_between:9,15',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'message' => 'nullable|string|max:500',
        ], [
            'phone.digits_between' => 'Nomor WhatsApp harus antara 9 sampai 15 digit.',
            'message.max'   => 'Pesan maksimal 500 karakter.',
            'image.max'     => 'Ukuran gambar maksimal 5MB.',
            'image.mimes'   => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.image'   => 'File yang diunggah bukan gambar.',
        ]);

        $skip = ltrim($request->phone, '0'); // buang 0 di depan kalau ada
        $phone = '62' . $skip;

        if ($request->hasFile('image')) {
            // ✅ Kirim gambar dengan caption
            $path = $request->file('image')->store('uploads', 'public');
            $imageUrl = asset(str_replace('public', 'storage', $path)); // buat URL public

            $result = $wa->sendImage($phone, $imageUrl, $validated['message'] ?? '');
        } else {
            // ✅ Kirim pesan teks biasa
            $result = $wa->sendMessage($phone, $validated['message']);
        }

        return $result['status']
            ? back()->with('success', '✅ Pesan berhasil dikirim ke ' . $phone)
            : back()->with('error', '❌ ' . $result['message']);
    }
}
