<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
//use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
{
    try {
        // Retrieve the user's data from Facebook using Socialite
        $facebookUser = Socialite::driver('facebook')->user();

        // Check if a user with the same Facebook ID exists in your application
        $user = User::where('facebook_id', $facebookUser->getId())->first();

        if (!$user) {
            // If the user doesn't exist, create a new user with the data from Facebook
            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'facebook_id' => $facebookUser->getId(),
                // Set a default or randomly generated password for the new user
                'password' => bcrypt(uniqid('facebook_')),
            ]);
        }

        // Log the user in using Laravel's Auth facade
        Auth::login($user);

        // Redirect the user to their intended destination
        return redirect()->intended(RouteServiceProvider::HOME);
    } catch (\Exception $e) {
        // Handle any errors that occur during the process
        return redirect('/login')->withErrors([
            'error' => 'There was an error logging in with Facebook. Please try again.',
        ]);
    }
}

}
