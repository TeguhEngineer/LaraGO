<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->otp_code !== null && Auth::user()->otp_expires_at !== null) {
            if (Auth::user()->otp_expires_at < now()) {
                Auth::user()->update(['otp_code' => null, 'otp_expires_at' => null]);
                return redirect()->route('dashboard');
            }

            return redirect()->route('verify.otp')
                ->with('warning', '⚠️ Akun kamu belum diverifikasi. Silakan masukkan kode OTP.');
        }


        return $next($request);
    }
}
