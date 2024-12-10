<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Mail\VerificationEmail;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:' . Admin::class,
            'password' => ['required','confirmed',Rules\Password::defaults()],
            'phone' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'google_id' => 'nullable|string|max:255',
        ],[],[
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'google_id' => 'Google Id',
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(422, 'Register Validation Error.', $validator->errors());
        }

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? null,
            'longitude' => $request->longitude ?? null,
            'latitude' => $request->latitude ?? null,
            'google_id' => $request->google_id ?? null,
        ]);
//        dd($user);

//        event(new Registered($user));
        $token = Str::random(64);
        DB::table('email_verifications')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);
        Mail::to($user->email)->send(new VerificationEmail($user->name, $token));

        $data['token']= $user->createToken('APIToken')->plainTextToken;
        $data['name']= $user->name;
        $data['email']= $user->email;

        return ApiResponse::sendResponse(201,'User Created Successfully',$data);

    }

    public function sendEmail()
    {
//        dd('here');
        Mail::to('recipient@example.com')->send(new TestMail());

        return response()->json([
            'message' => 'Email sent successfully!'
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');

        $record = DB::table('email_verifications')->where('token', $token)->first();

        if (!$record) {
            return ApiResponse::sendResponse(400, 'Invalid Token');
        }

        $user = Admin::where('email', $record->email)->first();
        if ($user) {
            $user->update(['email_verified_at' => now()]);
            DB::table('email_verifications')->where('email', $record->email)->delete();
            return ApiResponse::sendResponse(200, 'Email Verified Successfully');
        }
        return ApiResponse::sendResponse(200, 'User Not Found');

    }

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user('admin')->hasVerifiedEmail()) {
            return ApiResponse::sendResponse(200, 'User already verified.', null);
        }

        $request->user('admin')->sendEmailVerificationNotification();

        return ApiResponse::sendResponse(200,'Email verification link sent on your email address.', null);
    }

    public function verify(Request $request, $hash)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:admins,email',
            'hash' => 'required|string'
        ]);

        $admin = Admin::where('email', $request->email)->firstOrFail();

        if (!hash_equals((string) $hash, sha1($admin->getEmailForVerification()))) {
            return ApiResponse::sendResponse(403, 'This action is unauthorized.', null);
        }

        if ($admin->hasVerifiedEmail()) {
            return ApiResponse::sendResponse(200, 'User already verified.', null);
        }

        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        return ApiResponse::sendResponse(200, 'User successfully verified.', null);
    }
    public function login(Request $request)
    {
        dd($request);
    }
}
