<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DevicesController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Halaman devices - utama untuk menampilkan status login
     */
    public function devices()
    {
        // Cek status login terlebih dahulu via /app/devices
        $devicesResult = $this->whatsappService->getDevices();

        if ($devicesResult['status'] && $devicesResult['data']['code'] === 'SUCCESS' && !empty($devicesResult['data']['results'])) {
            // Debug: Log struktur data yang diterima (hanya di development)
            if (app()->environment(['local', 'development'])) {
                Log::info('Devices API Response:', [
                    'full_response' => $devicesResult,
                    'results' => $devicesResult['data']['results']
                ]);
            }
            
            // Sudah login - tampilkan info devices
            return view('pages.devices.index', [
                'isLoggedIn' => true,
                'devicesInfo' => $devicesResult['data']['results']
            ]);
        } else {
            // Belum login - tampilkan QR code
            $loginResult = $this->whatsappService->login();
            
            if ($loginResult['status'] && $loginResult['data']['code'] === 'SUCCESS') {
                // Simpan session QR code untuk pengecekan status
                session(['qr_session' => [
                    'generated_at' => now(),
                    'duration' => $loginResult['data']['results']['qr_duration'],
                    'qr_link' => $loginResult['data']['results']['qr_link']
                ]]);
            }

            return view('pages.devices.index', [
                'isLoggedIn' => false,
                'qrData' => $loginResult['status'] ? $loginResult['data'] : null
            ]);
        }
    }


    /**
     * Endpoint untuk AJAX check status login (polling)
     */
    public function checkLoginStatus()
    {
        $devicesResult = $this->whatsappService->getDevices();
        
        $isLoggedIn = $devicesResult['status'] && 
                     $devicesResult['data']['code'] === 'SUCCESS' && 
                     !empty($devicesResult['data']['results']);
        
        // Jika berhasil login, clear QR session
        if ($isLoggedIn) {
            session()->forget('qr_session');
        }

        return response()->json([
            'isLoggedIn' => $isLoggedIn,
            'devicesInfo' => $isLoggedIn ? $devicesResult['data']['results'] : null,
            'qrSession' => session('qr_session')
        ]);
    }

    /**
     * Logout dari WhatsApp
     */
    public function logout()
    {
        $logoutResult = $this->whatsappService->logout();
        
        // Clear session regardless of result
        session()->forget('qr_session');
        
        if ($logoutResult['status']) {
            return redirect()->route('devices.index')
                ->with('success', 'Berhasil logout dari WhatsApp');
        } else {
            return redirect()->route('devices.index')
                ->with('error', 'Error saat logout: ' . $logoutResult['message']);
        }
    }
    
    /**
     * Reconnect WhatsApp
     */
    public function reconnect()
    {
        $reconnectResult = $this->whatsappService->reconnect();
        
        if ($reconnectResult['status'] && $reconnectResult['data']['code'] === 'SUCCESS') {
            // Update session QR code untuk pengecekan status
            session(['qr_session' => [
                'generated_at' => now(),
                'duration' => $reconnectResult['data']['results']['qr_duration'],
                'qr_link' => $reconnectResult['data']['results']['qr_link']
            ]]);
            
            return redirect()->route('devices.index')
                ->with('success', 'Berhasil reconnect WhatsApp');
        } else {
            return redirect()->route('devices.index')
                ->with('error', 'Error saat reconnect: ' . ($reconnectResult['message'] ?? 'Unknown error'));
        }
    }

    /**
     * Generate QR Code via AJAX (tanpa refresh halaman)
     */
    public function generateQR()
    {
        $loginResult = $this->whatsappService->login();
        
        if ($loginResult['status'] && $loginResult['data']['code'] === 'SUCCESS') {
            // Simpan session QR code untuk pengecekan status
            session(['qr_session' => [
                'generated_at' => now(),
                'duration' => $loginResult['data']['results']['qr_duration'],
                'qr_link' => $loginResult['data']['results']['qr_link']
            ]]);

            return response()->json([
                'success' => true,
                'data' => $loginResult['data'],
                'qr_session' => session('qr_session')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $loginResult['message'] ?? 'Gagal generate QR code',
                'data' => $loginResult['status'] ? $loginResult['data'] : null
            ], 500);
        }
    }

    /**
     * Debug method untuk test API response
     */
    public function debugDevices()
    {
        $devicesResult = $this->whatsappService->getDevices();
        
        return response()->json([
            'service_response' => $devicesResult,
            'extracted_results' => $devicesResult['data']['results'] ?? null,
            'status_check' => [
                'has_status' => isset($devicesResult['status']),
                'status_value' => $devicesResult['status'] ?? null,
                'has_data' => isset($devicesResult['data']),
                'data_code' => $devicesResult['data']['code'] ?? null,
                'results_empty' => empty($devicesResult['data']['results'] ?? [])
            ]
        ]);
    }

    /**
     * Server-Sent Events for real-time status updates
     */
    public function statusStream()
    {
        // Set time limit untuk long-running request
        set_time_limit(0);
        
        return response()->stream(function () {
            $lastStatus = null;
            $checkCount = 0;
            $maxChecks = 60; // Maximum 5 minutes (60 * 5 seconds)
            
            // Send initial connection confirmation
            echo "data: " . json_encode([
                'type' => 'connected',
                'message' => 'SSE connection established',
                'timestamp' => now()->toISOString()
            ]) . "\n\n";
            ob_flush();
            flush();
            
            while ($checkCount < $maxChecks) {
                try {
                    $devicesResult = $this->whatsappService->getDevices();
                    $isLoggedIn = $devicesResult['status'] && 
                                 isset($devicesResult['data']['code']) &&
                                 $devicesResult['data']['code'] === 'SUCCESS' && 
                                 !empty($devicesResult['data']['results']);
                    
                    // Send update if status changed OR every 10 checks (heartbeat)
                    if ($isLoggedIn !== $lastStatus || $checkCount % 10 === 0) {
                        $data = json_encode([
                            'type' => 'status_update',
                            'isLoggedIn' => $isLoggedIn,
                            'devicesInfo' => $isLoggedIn ? $devicesResult['data']['results'] : null,
                            'timestamp' => now()->toISOString(),
                            'checkCount' => $checkCount
                        ]);
                        
                        echo "data: {$data}\n\n";
                        ob_flush();
                        flush();
                        
                        $lastStatus = $isLoggedIn;
                        
                        // If logged in, send final message and stop
                        if ($isLoggedIn) {
                            echo "data: " . json_encode([
                                'type' => 'login_success',
                                'message' => 'WhatsApp successfully connected!',
                                'timestamp' => now()->toISOString()
                            ]) . "\n\n";
                            ob_flush();
                            flush();
                            break;
                        }
                    }
                    
                    $checkCount++;
                    sleep(5); // Check every 5 seconds (server-side)
                    
                } catch (\Exception $e) {
                    // Send error message
                    echo "data: " . json_encode([
                        'type' => 'error',
                        'message' => 'Connection error: ' . $e->getMessage(),
                        'timestamp' => now()->toISOString()
                    ]) . "\n\n";
                    ob_flush();
                    flush();
                    break;
                }
            }
            
            // Send timeout message if max checks reached
            if ($checkCount >= $maxChecks) {
                echo "data: " . json_encode([
                    'type' => 'timeout',
                    'message' => 'SSE connection timeout, please refresh page',
                    'timestamp' => now()->toISOString()
                ]) . "\n\n";
                ob_flush();
                flush();
            }
            
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Disable nginx buffering
        ]);
    }
}
