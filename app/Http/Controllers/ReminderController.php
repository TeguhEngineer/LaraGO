<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        // $reminders = Reminder::where('user_id', Auth::id())->latest()->get();
        $reminders = Reminder::latest()->paginate(10);
        $users = User::all();
        return view('pages.reminders.index', compact('reminders', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_at'   => 'required|date|after:now',
        ], [
            '*.required' => 'Field harus diisi.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
            'reminder_at.after' => 'Tanggal harus lebih besar dari sekarang.',
            'reminder_at.required' => 'Tanggal harus diisi.',
            'reminder_at.max' => 'Tanggal tidak boleh lebih dari 255 karakter.',
        ]);

        Reminder::create($validated + ['status' => 'pending']);

        return back()->with('success', '✅ Reminder berhasil ditambahkan!');
    }
}
