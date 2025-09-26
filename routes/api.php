<?php

use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SendMultiTypeMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/test-api', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working',
    ], 200);
});
Route::post('/send', [SendMultiTypeMessageController::class, 'send']);
