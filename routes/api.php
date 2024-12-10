<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ICController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function (Request $request) {
    dump('hello from API');
});

# ------------------- Auth Module ---------------#
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

# ------------------- Settings Module ---------------#
Route::get('/settings', SettingController::class);

# ------------------- Stores Module ---------------#
Route::get('/stores', StoreController::class);

# ------------------- Messages Module ---------------#
Route::post('/message', MessageController::class);


# ------------------- IC Module ---------------#
Route::prefix('ic')->controller(ICController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/imagestore', 'storeImage');
    Route::post('/search', 'searchIC');
//    Route::post('/searchic', 'searchIC2');
    Route::post('/store', 'store');
});

# ------------------- Admin Module ---------------#
//Route::prefix('admin')->name('admin.')->middleware('auth:sanctum')->group(function () {
//    Route::get('/users', function () {
//
//    });
//});

use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    $toEmail = 'recipient@example.com'; // Replace with a valid recipient email
    Mail::raw('This is a test email via port 465 and SSL.', function ($message) use ($toEmail) {
        $message->to($toEmail)
            ->subject('Test Email');
    });

    return 'Test email sent.';
});
