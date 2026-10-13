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
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usercode' => ['required', 'string'],
            'userpass' => ['required', 'string'],
        ]);

        $user = User::where('usercode', $request->usercode)
            ->where('permission', '<=', 1)
            ->first();

        if ($user && Hash::check($request->userpass, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            session([
                'permission' => $user->permission,
                'username' => $user->username,
                'userid' => $user->id,
            ]);

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['login' => '帳號或密碼錯誤'])
            ->withInput($request->only('usercode'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}