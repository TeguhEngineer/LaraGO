<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        return view('auth.verify-otp');
    }

    public function store(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $user = User::find(session('pending_user_id'));

        if (!$user) {
            return back()->withErrors(['session_null' => 'Sesi OTP tidak ditemukan, silahkan daftar ulang.']);
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if ($user->otp_expires_at < now()) {
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            return back()->withErrors(['otp_expired' => 'Kode OTP sudah kadaluarsa, silakan minta kode baru.']);
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_verified_at' => now(),
        ]);

        session()->forget('pending_user_id');

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil!');
    }

    public function resendOtp(Request $request, WhatsAppService $wa)
    {
        $user = User::where('id', session('pending_user_id'))->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Sesi OTP tidak ditemukan, silahkan daftar ulang.']);
        }

        $otp = rand(100000, 999999);

        $user->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $wa->sendMessage(
            $user->phone,
            "Halo {$user->name}, kode OTP baru kamu adalah: *{$otp}*.\n\nKode berlaku 5 menit."
        );

        return back()->with('success', 'Kode OTP baru telah dikirim ke WhatsApp Anda.');
    }
}
