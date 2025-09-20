<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;

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
        // Validasi file upload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Import
        Excel::import(new ContactsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Kontak berhasil diimport.');
    }
}
