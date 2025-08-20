<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        $user = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'Bu email allaqachon ro‘yxatdan o‘tgan!',
        ]);


        $user = User::create($user);

        Mail::raw('Salom, bu test xabari', function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Test email');
        });


        return redirect()->route('login');

    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    public function showLogin()
    {

        return view('auth.login');
    }


    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');

    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google OAuth callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Str::password(12),
                'email_verified_at' => now()
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Google orqali tizimga muvaffaqiyatli kirdingiz!');
    }
}
