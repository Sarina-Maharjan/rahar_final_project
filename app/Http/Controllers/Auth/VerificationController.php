<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function showVerificationForm()
    {
        return view('auth.verify_code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid verification code.');
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->email_verified =  true;
        $user->save();

        Auth::login($user); // auto login after verification
        return redirect('/')->with('success', 'Your email has been verified.');
    }

    public function resend(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $newCode = rand(100000, 999999);
        $user->verification_code = $newCode;
        $user->save();

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user));
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return back()->with('error', 'Unable to send verification email. Please try again.');
        }

        return redirect()->back()->with('success', 'A new verification code has been sent to your email.');
    }
}
