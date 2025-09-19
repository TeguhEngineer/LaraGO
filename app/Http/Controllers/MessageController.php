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
            'phone'   => 'required|string|max:15',
            'message' => 'required|string|max:500',
        ]);

        if (!is_numeric($request->phone)) {
            return back()->with('error', 'Nomor WhatsApp harus berupa angka.');
        }

        $result = $wa->sendMessage($request->phone, $request->message);

        if ($result['status']) {
            return back()->with('success', 'Pesan berhasil dikirim ke nomor WhatsApp ' . $request->phone);
        }

        return back()->withErrors(['wa' => $result['message'] ?? 'Gagal mengirim pesan.']);
    }
}
