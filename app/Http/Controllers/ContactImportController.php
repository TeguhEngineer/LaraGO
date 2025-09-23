<?php
// app/Http/Controllers/ContactImportController.php

namespace App\Http\Controllers;

use App\Imports\ContactsTempImport;
use App\Models\Contact;
use App\Models\ContactTemp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactImportController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        // Kosongkan tabel temporary
        ContactTemp::truncate();

        // Import ke tabel temporary
        Excel::import(new ContactsTempImport, $request->file('file'));

        // Cek duplikat dalam file dan di database
        $temps = ContactTemp::all();
        $phones = $temps->pluck('phone')->filter()->toArray(); // Filter null values
        $phoneCounts = array_count_values($phones);
        $existingPhones = Contact::whereIn('phone', array_unique($phones))->pluck('phone')->toArray();

        foreach ($temps as $temp) {
            $errors = json_decode($temp->error_messages, true) ?? [];
            $phone = $temp->phone;

            if ($phone && ($phoneCounts[$phone] ?? 0) > 1) {
                $errors[] = 'Nomor telepon duplikat di dalam file.';
            }

            if ($phone && in_array($phone, $existingPhones)) {
                $errors[] = 'Nomor telepon sudah ada di database.';
            }

            if (!empty($errors)) {
                $temp->is_valid = false;
                $temp->error_messages = json_encode(array_unique($errors));
                $temp->save();
            }
        }

        return redirect()->route('pages.contact.preview')
            ->with('success', 'File berhasil diupload, silakan periksa datanya.');
    }

    public function preview()
    {
        $temps = ContactTemp::all();
        return view('pages.contact.preview', compact('temps'));
    }

    public function confirm(Request $request)
    {
        $ids = $request->input('selected', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih untuk diimport.');
        }

        $rows = ContactTemp::whereIn('id', $ids)->where('is_valid', true)->get();

        foreach ($rows as $row) {
            if (Contact::where('phone', $row->phone)->exists()) {
                continue;
            }
            Contact::create([
                'name' => $row->name,
                'phone' => $row->phone,
            ]);
        }

        ContactTemp::truncate(); // Kosongkan temp setelah confirm

        return redirect()->route('contacts.index')->with('success', 'Data valid berhasil diimport.');
    }
}
