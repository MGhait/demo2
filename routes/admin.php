<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'hello from admin';
});
Route::controller(AdminController::class)->group(function () {

//    Route::middleware('guest')->group(function () {
        Route::post('register', 'register');
        Route::post('/login', 'login');

//    Route::post('/send-email',  'sendEmail');
//    });
    Route::get('/mail-test', function() {
        try {
            $result = Mail::raw('Test email', function ($message) {
                $message->to('test@example.com')
                    ->subject('DDEV Mail Test');
            });
            return 'Email attempt logged. Check logs.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getTraceAsString();
        }
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/sendEmail', 'sendVerificationEmail');
        Route::get('/verify/{token}', 'verify');
//        Route::get('/login', 'login');
    });

//    Route::get('verify-email/{token}','verifyEmail');
//});
//
//Route::middleware('auth:sanctum')->group(function () {
//    Route::post('/email/verification-notification', function (Request $request) {
//        $request->user()->sendEmailVerificationNotification();
//
//        return response()->json(['message' => 'Verification email sent!']);
//    });
//
//    Route::get('/verify/{hash}', function (EmailVerificationRequest $request) {
//        $request->fulfill();
//
//        return response()->json(['message' => 'Email verified successfully!']);
//    })->name('verification.verify');
});
