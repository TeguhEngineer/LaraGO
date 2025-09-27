<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ContactImportController;
use App\Http\Controllers\DevicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // dd(session()->all());
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/devices', [DevicesController::class, 'devices'])->name('devices.index');
    Route::get('/check-status', [DevicesController::class, 'checkLoginStatus'])->name('devices.status');
    Route::get('/whatsapp-status-stream', [DevicesController::class, 'statusStream'])->name('devices.status-stream');
    
    // Debug route - hanya tersedia di development
    if (app()->environment(['local', 'development'])) {
        Route::get('/debug-devices', [DevicesController::class, 'debugDevices'])->name('devices.debug');
    }
    Route::post('/generate-qr', [DevicesController::class, 'generateQR'])->name('devices.generate-qr');
    Route::post('/devices/logout', [DevicesController::class, 'logout'])->name('devices.logout');
    Route::post('/devices/reconnect', [DevicesController::class, 'reconnect'])->name('devices.reconnect');

    Route::post('/contacts/import/upload', [ContactImportController::class, 'upload'])->name('contacts.import.upload');
    Route::get('/contacts/import/preview', [ContactImportController::class, 'preview'])->name('pages.contact.preview');
    Route::post('/contacts/import/confirm', [ContactImportController::class, 'confirm'])->name('contacts.import.confirm');

    Route::get('/send_message', [MessageController::class, 'index'])->name('message.index');
    Route::post('/send_message', [MessageController::class, 'send'])->name('send.message');

    Route::get('/reminders_message', [ReminderController::class, 'index'])->name('reminders.index');
    Route::get('/reminders/data', [ReminderController::class, 'data'])->name('reminders.data');
    Route::post('/reminders_message', [ReminderController::class, 'store'])->name('reminders.store');

    Route::resource('/contacts', ContactController::class);




    // Route::post('/webhook/gowa', [WebhookController::class, 'handle']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
