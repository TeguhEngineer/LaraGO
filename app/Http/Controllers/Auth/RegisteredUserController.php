<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // dd(session()->all());
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, WhatsAppService $wa): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $result = $wa->sendMessage(
        //     $request->phone,
        //     "Halo {$request->name}, selamat datang di website kami!"
        // );

        // $customMessages = [
        //     'you are not connect to services server, please reconnect' => '❌ WA Gateway belum online, hubungkan device terlebih dahulu.',
        //     'Invalid number' => '⚠️ Nomor WhatsApp salah atau tidak terdaftar.',
        // ];

        // if (!$result['status']) {
        //     $errorMessage = $customMessages[$result['message']] ?? 'Terjadi kesalahan tidak diketahui.';
        //     return back()->withErrors(['wa' => $errorMessage]);
        // }

        // $otp = rand(100000, 999999);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'password'       => Hash::make($request->password),
            // 'otp_code'       => $otp,
            // 'otp_expires_at' => now()->addMinutes(5),
            // 'otp_verified_at' => null,
        ]);

        // session(['pending_user_id' => $user->id]);

        event(new Registered($user));

        // $wa->sendMessage(
        //     $user->phone,
        //     "Halo {$user->name}, kode OTP kamu adalah: *{$otp}*.\n\nKode berlaku 5 menit."
        // );

        // return redirect()->route('verify.otp')->with('success', 'Akun berhasil dibuat! Silakan cek WhatsApp untuk kode OTP.');

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
