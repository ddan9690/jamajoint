<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;

class PasswordResetController extends Controller
{
    public function showForgetPasswordForm(){
        return view('auth.password.old-reset');
    }

    public function submitForgetPasswordForm(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::send('auth.password.email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->back()->with('success', 'A password reset link has been sent to your email address. Please check your inbox.');
    } catch (QueryException $e) {
        // Check for duplicate entry error (Integrity constraint violation)
        if ($e->errorInfo[1] == 1062) {
            // Handle the case where the email already has an existing token
            return redirect()->back()->withErrors(['email' => 'A password reset link has already been sent to this email address. Please check your inbox.']);
        }

        // For other database-related errors, you may want to log or handle differently
        return redirect()->back()->withErrors(['email' => 'An error occurred. Please try again later.']);
    }
}

      public function showResetPasswordForm($token) {
        return view('auth.password.reset', ['token' => $token]);
     }

     public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token
                              ])
                              ->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

          return redirect('/login')->with('success', 'You have successfully reset your password');
      }


    // password reset from the dashboard area
    public function changePassword(){
        return view('password.dash.changePassword');

    }
}
