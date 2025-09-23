<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ReminderController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('pages.reminders.index', compact('contacts'));
    }

    public function data()
    {
        $reminders = Reminder::with('contact')->select('reminders.*');
        return DataTables::of($reminders)
            ->addColumn('action', function ($reminder) {
                return '
        <button type="button" class="inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-yellow-400 dark:from-yellow-500 to-yellow-500 dark:to-yellow-600 rounded hover:from-yellow-500 dark:hover:from-yellow-400 hover:to-yellow-600 dark:hover:to-yellow-500 transition-all duration-200">
            Edit
        </button>
        <button type="button" class="inline-flex items-center px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-red-400 dark:from-red-500 to-red-500 dark:to-red-600 rounded hover:from-red-500 dark:hover:from-red-400 hover:to-red-600 dark:hover:to-red-500 transition-all duration-200">
            Delete
        </button>
    ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $validated = $request->validate([
                'contact_id'     => 'required|exists:contacts,id',
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'reminder_at'   => 'required|date|after:now',
            ], [
                '*.required' => 'Field tidak boleh kosong.',
                'contact_id.exists' => 'Kontak tidak ditemukan.',
                'reminder_at.after' => 'Tanggal harus lebih besar dari sekarang.',
                'reminder_at.required' => 'Tanggal harus diisi.',
                'reminder_at.max' => 'Tanggal tidak boleh lebih dari 255 karakter.',
            ]);


            Reminder::create($validated);

            return back()->with('success', '✅ Reminder berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator);
            // ->withInput()
            // ->with('add', true);
        } catch (\Throwable $th) {
            Log::error('Error saat menyimpan data: ' . $th->getMessage());
            return back()->with('error', 'Gagal menyimpan data:' . $th->getMessage());
        }
    }
}
