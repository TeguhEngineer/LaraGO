<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // dd(session()->all());
    return view('dashboard');
})->middleware(['auth', 'verified', 'otp.verified'])->name('dashboard');

Route::middleware('otp.redirect')->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'index'])->name('verify.otp');
    Route::post('/verify-otp', [OtpController::class, 'store'])->name('store.verify-otp');
    Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('resend.otp');
});

Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/send_message', [MessageController::class, 'index'])->name('message.index');
    Route::post('/send_message', [MessageController::class, 'send'])->name('send.message');
    Route::get('/reminders_message', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/reminders_message', [ReminderController::class, 'store'])->name('reminders.store');

    Route::post('/webhook/gowa', [WebhookController::class, 'handle']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
