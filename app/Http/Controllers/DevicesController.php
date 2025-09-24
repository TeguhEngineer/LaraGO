<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DevicesController extends Controller
{
    private $baseUrl;
    private $timeout = 30;

    public function __construct()
    {
        $this->baseUrl = config('services.gowa.url', 'http://localhost:3000');
    }

    /**
     * Halaman devices - utama untuk menampilkan status login
     */
    public function devices()
    {
        // Cek status login terlebih dahulu via /app/devices
        $devicesInfo = $this->getDevicesInfo();

        if ($devicesInfo && $devicesInfo['code'] === 'SUCCESS' && !empty($devicesInfo['results'])) {
            // Sudah login - tampilkan info devices
            return view('pages.devices.index', [
                'isLoggedIn' => true,
                'devicesInfo' => $devicesInfo['results']
            ]);
        } else {
            // Belum login - tampilkan QR code
            $qrData = $this->generateQRCode();

            return view('pages.devices.index', [
                'isLoggedIn' => false,
                'qrData' => $qrData
            ]);
        }
    }

    /**
     * Generate QR Code untuk login
     */
    private function generateQRCode()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/app/login');

            if ($response->successful()) {
                $data = $response->json();

                // Simpan session QR code untuk pengecekan status
                if ($data['code'] === 'SUCCESS') {
                    session(['qr_session' => [
                        'generated_at' => now(),
                        'duration' => $data['results']['qr_duration'],
                        'qr_link' => $data['results']['qr_link']
                    ]]);
                }

                return $data;
            }

            return null;
        } catch (\Exception $e) {
            logger()->error('QR Code Generation Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Cek status login user via endpoint /app/devices
     */
    private function getDevicesInfo()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/app/devices');

            if ($response->successful()) {
                $data = $response->json();

                // Jika berhasil mendapatkan devices info, clear QR session
                if ($data['code'] === 'SUCCESS' && !empty($data['results'])) {
                    session()->forget('qr_session');
                }

                return $data;
            }

            return null;
        } catch (\Exception $e) {
            logger()->error('Devices Info Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Endpoint untuk AJAX check status login (polling)
     */
    public function checkLoginStatus()
    {
        $devicesInfo = $this->getDevicesInfo();

        return response()->json([
            'isLoggedIn' => $devicesInfo && $devicesInfo['code'] === 'SUCCESS' && !empty($devicesInfo['results']),
            'devicesInfo' => $devicesInfo ? $devicesInfo['results'] : null,
            'qrSession' => session('qr_session')
        ]);
    }

    /**
     * Logout dari WhatsApp
     */
    public function logout()
    {
        try {
            // Endpoint logout (sesuaikan dengan API yang tersedia)
            $response = Http::get($this->baseUrl . '/app/logout');

            session()->forget('qr_session');

            return redirect()->route('devices.index')
                ->with('success', 'Berhasil logout dari WhatsApp');
        } catch (\Exception $e) {
            return redirect()->route('devices.index')
                ->with('error', 'Error saat logout: ' . $e->getMessage());
        }
    }
}
