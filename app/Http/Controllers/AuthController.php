<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        $users = User::all();
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required!!.',
            'password.required' => 'Password is required!!.',
        ]);

        $user = User::where('email', $request->email)->where('password', $this->encrypt_password($request->password))->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard.index')->with('success', 'You are logged in.');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {

        auth()->logout();
        return redirect('/login');
    }

    public function showRegistrationForm()
    {

        $register = new User();

        return view('backend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->encrypt_password($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
    private function encrypt_password($password)
    {
        return sha1(md5($password . 'Samail$alt'));
    }

    public function changePassword()
    {

        return view('backend.auth.change-password');
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $user = User::find(auth()->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            if ($request->new_password == $request->confirm_password) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return redirect()->route('dashboard.index')->with('success', 'Password changed successfully.');
            } else {
                return back()->withErrors([
                    'confirm_password' => 'The provided credentials do not match our records.',
                ]);
            }
        }
    }
}
