<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function generateOtp($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        $otp = rand(1000, 9999);

        $user->verification_otp = $otp;
        $user->otp_expiry = Carbon::now()->addMinutes(10);
        $user->save();

        return $otp;
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');

        $user = User::where('verification_otp', $otp)->where('otp_expiry', '>=', now())->first();

        if (!$user) {
            return redirect()->route('verify-otp')->with('error', 'Invalid OTP code.');
        }

        $user->email_verified_at = now();
        $user->verification_otp = null;
        $user->otp_expiry = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
