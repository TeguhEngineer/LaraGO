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
        $request->validate([
            'phone' => 'required|digits_between:9,15',
            'message' => 'required|string|max:500',
        ], [
            'phone.digits_between' => 'Nomor WhatsApp harus antara 9 sampai 15 digit.',
            'message.max'   => 'Pesan maksimal 500 karakter.',
        ]);

        // if (!is_numeric($request->phone)) {
        //     return back()->with('error', 'Nomor WhatsApp harus berupa angka.');
        // }

        $phone = ltrim($request->phone, '0'); // buang 0 di depan kalau ada
        $format = '62' . $phone;

        $result = $wa->sendMessage($format, $request->message);

        if ($result['status']) {
            return back()->with('success', 'Pesan berhasil dikirim ke nomor WhatsApp ' . $request->phone);
        }

        return back()->withErrors(['wa' => $result['message'] ?? 'Gagal mengirim pesan.']);
    }
}
