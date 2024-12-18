<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user information from Google
            $user = Socialite::driver('google')->user();

            // Check if a user with this email exists in the database
            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {
                // If user exists, update google_id and google_token
                $finduser->google_id = $user->id; // Update Google ID
                $finduser->google_token = $user->token; // Update Google Token
                $finduser->save(); // Save the changes

                // Log them in
                Auth::login($finduser);
                return redirect()->intended('dashboard')->with('success', 'Login berhasil');
            } else {
                // If user does not exist, redirect with a message
                return redirect()->route('login')->with('error', 'Email anda tidak terdaftar');
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log them or show a user-friendly error)
            return redirect()->route('login')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
