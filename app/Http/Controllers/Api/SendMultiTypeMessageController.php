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
            'phone'   => 'required|digits_between:9,15',
            'message' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'file'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,mp3,mp4,avi,mov|max:10240', // max 10MB
        ], [
            '*.required' => 'Kolom inputan ini harus diisi.',
            'phone.digits_between' => 'Nomor WhatsApp harus antara 9 sampai 15 digit.',
            'message.max'   => 'Pesan maksimal 500 karakter.',
            'image.max'     => 'Ukuran gambar maksimal 5MB.',
            'image.mimes'   => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.image'   => 'File yang diunggah bukan gambar.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
            'file.mimes'    => 'Format file harus pdf, doc, docx, xls, xlsx, ppt, pptx, txt, zip, rar, mp3, mp4, avi, atau mov.',
        ]);

        $skip = ltrim($validated['phone'], '0'); // buang 0 di depan kalau ada
        $phone = '62' . $skip;

        try {
            $messageType = 'text';
            $result = null;

            if ($request->hasFile('image')) {
                // ✅ Kirim gambar dengan caption
                $image = $request->file('image');
                $path = $image->store('uploads/images', 'public');
                $imagePath = storage_path('app/public/' . $path);
                
                // Gunakan imageFile parameter untuk mengirim file langsung
                $result = $this->wa->sendImage($phone, null, $validated['message'] ?? '', false, false, false, 3600, $imagePath);
                $messageType = 'image';
                
            } elseif ($request->hasFile('file')) {
                // ✅ Kirim file dengan caption
                $file = $request->file('file');
                
                // Simpan file dengan nama yang lebih deskriptif untuk storage
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                
                $path = $file->storeAs('uploads/files', $fileName, 'public');
                $filePath = storage_path('app/public/' . $path);
                
                // Debug: Log file information
                Log::info('File Upload Debug', [
                    'original_name' => $originalName,
                    'stored_name' => $fileName,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'stored_path' => $path,
                    'full_path' => $filePath,
                    'file_exists' => file_exists($filePath),
                    'file_size_after_store' => file_exists($filePath) ? filesize($filePath) : 'N/A',
                    'file_readable' => file_exists($filePath) ? is_readable($filePath) : false
                ]);
                
                // Pastikan file tersimpan dengan benar sebelum mengirim
                if (!file_exists($filePath) || !is_readable($filePath)) {
                    throw new \Exception('File tidak tersimpan dengan benar atau tidak dapat dibaca');
                }
                
                // Kirim file dengan nama asli
                $result = $this->wa->sendFile($phone, $filePath, $validated['message'] ?? '', $originalName);
                $messageType = 'file';
                
            } else {
                // ✅ Kirim pesan teks biasa
                $result = $this->wa->sendMessage($phone, $validated['message']);
                $messageType = 'text';
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'type'    => $messageType,
                'data'    => $result
            ], 200);
            
        } catch (\Throwable $th) {
            Log::error("Error saat mengirim pesan (API): " . $th->getMessage());
            
            return response()->json([
                'success' => false,
                'error'   => $th->getMessage()
            ], 500);
        }
    }
}
