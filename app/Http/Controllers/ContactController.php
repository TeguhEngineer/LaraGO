<?php

namespace App\Http\Controllers;


use App\Models\contact;
use Illuminate\Http\Request;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = contact::paginate(4);
        return view('pages.contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        contact::create($data);
        return redirect()->back()->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contact $contact)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        $contact->update($data);
        return redirect()->back()
            ->with('success', 'Kontak berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contact $contact)
    {
        $contact->delete();

        return redirect()->back()
            ->with('success', 'Kontak berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new ContactsImport();
        Excel::import($import, $request->file('file'));

        $rows = collect($import->rows);

        $errors = [];
        $validData = [];

        // Ambil semua phone di file
        $phones = $rows->pluck('phone')->filter()->all();
        $phoneCounts = array_count_values($phones);

        // Phone yang sudah ada di DB
        $existingPhones = Contact::whereIn('phone', array_unique($phones))
            ->pluck('phone')->toArray();

        foreach ($rows as $index => $row) {
            $rowNum = $row['row']; // baris ke Excel (sudah ditambah di ContactsImport)
            $name   = trim($row['name']);
            $phone  = trim($row['phone']);

            $rowErrors = [];

            // Validasi kosong
            if ($name === '') {
                $rowErrors[] = 'Nama tidak boleh kosong.';
            }
            if ($phone === '') {
                $rowErrors[] = 'Nomor telepon tidak boleh kosong.';
            }

            // Validasi format phone
            if ($phone !== '' && !preg_match('/^\d{8,15}$/', $phone)) {
                $rowErrors[] = 'Nomor telepon harus angka 8–15 digit.';
            }

            // Validasi duplikat di file
            if ($phone !== '' && ($phoneCounts[$phone] ?? 0) > 1) {
                $rowErrors[] = 'Nomor telepon duplikat di file.';
            }

            if (!empty($rowErrors)) {
                $errors[] = [
                    'row'      => $rowNum,
                    'messages' => $rowErrors,
                ];
            } else {
                $validData[] = [
                    'row'   => $rowNum,
                    'name'  => $name,
                    'phone' => $phone,
                ];
            }
        }

        // Kalau semua baris error → batal
        if (empty($validData)) {
            return back()->with(['errors_import' => $errors]);
        }

        // Simpan kandidat valid di session
        session(['import_valid_data' => $validData]);

        // Kalau ada error format/kosong → minta konfirmasi
        if (!empty($errors)) {
            return back()->with([
                'errors_import' => $errors,
                'need_confirm'  => true,
            ]);
        }

        // Kalau tidak ada error format, tapi ada duplikat di DB → minta konfirmasi skip
        $hasDuplicateDb = collect($validData)->pluck('phone')->intersect($existingPhones);
        if ($hasDuplicateDb->isNotEmpty()) {
            return back()->with([
                'existing_rows'   => $hasDuplicateDb,
                'need_confirm_skip' => true,
            ]);
        }

        // Kalau semua aman → langsung insert
        foreach ($validData as $d) {
            if (!Contact::where('phone', $d['phone'])->exists()) {
                Contact::create([
                    'name'  => $d['name'],
                    'phone' => $d['phone'],
                ]);
            }
        }

        session()->forget('import_valid_data');

        return back()->with('success', count($validData) . ' data berhasil diimport.');
    }

    public function confirmImport(Request $request)
    {
        $validData = session('import_valid_data', []);

        if (empty($validData)) {
            return back()->with('error', 'Tidak ada data valid untuk diimport.');
        }

        $inserted = 0;
        foreach ($validData as $d) {
            if (!Contact::where('phone', $d['phone'])->exists()) {
                Contact::create([
                    'name'  => $d['name'],
                    'phone' => $d['phone'],
                ]);
                $inserted++;
            }
        }

        session()->forget('import_valid_data');

        return back()->with('success', "$inserted data berhasil disimpan (baris invalid dilewati).");
    }

    // public function importSkipDuplicate(Request $request)
    // {
    //     // Ambil data valid yang sudah disimpan sementara di session
    //     $validData = session('import_valid_data', []);

    //     if (empty($validData)) {
    //         return back()->with('error', 'Tidak ada data untuk diimport.');
    //     }

    //     foreach ($validData as $data) {
    //         // Skip jika sudah ada di database
    //         if (!Contact::where('phone', $data['phone'])->exists()) {
    //             Contact::create([
    //                 'name' => $data['name'],
    //                 'phone' => $data['phone'],
    //             ]);
    //         }
    //     }

    //     // Bersihkan session
    //     session()->forget('import_valid_data');

    //     return back()->with('success', 'Data berhasil diimport dengan skip duplikat.');
    // }
}
