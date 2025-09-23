<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('pages.contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:8,15|unique:contacts,phone',
        ]);

        Contact::create($data);

        return back()->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:8,15|unique:contacts,phone,' . $contact->id,
        ]);

        $contact->update($data);

        return back()->with('success', 'Kontak berhasil diperbarui.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Kontak berhasil dihapus.');
    }
}