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
        try {
            // Test basic response first
            if (request()->has('test')) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Route is working',
                    'timestamp' => now()
                ]);
            }

            $reminders = Reminder::with('contact')->get();

            return DataTables::of($reminders)
                ->addIndexColumn()
                ->addColumn('action', function ($reminder) {
                    $editBtn = '<button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-colors duration-200" title="Edit reminder">Edit</button>';
                    $deleteBtn = '<button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors duration-200 ml-2" title="Hapus reminder" onclick="confirmDelete(' . $reminder->id . ', \'' . addslashes($reminder->title ?? '') . '\')">Hapus</button>';

                    return '<div class="flex items-center justify-center space-x-2">' . $editBtn . $deleteBtn . '</div>';
                })
                ->addColumn('contact_name', function ($reminder) {
                    return $reminder->contact ? $reminder->contact->name : '-';
                })
                ->editColumn('status', function ($reminder) {
                    return $reminder->status ?? 'pending';
                })
                ->editColumn('reminder_at', function ($reminder) {
                    if ($reminder->reminder_at) {
                        try {
                            return $reminder->reminder_at->format('Y-m-d H:i:s');
                        } catch (\Exception $e) {
                            return $reminder->reminder_at;
                        }
                    }
                    return '-';
                })
                ->editColumn('description', function ($reminder) {
                    return $reminder->description ?? '-';
                })
                ->editColumn('title', function ($reminder) {
                    return $reminder->title ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('DataTables Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => request()->all()
            ]);

            return response()->json([
                'draw' => request()->get('draw', 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error loading data: ' . $e->getMessage()
            ], 500);
        }
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
