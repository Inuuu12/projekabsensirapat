<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController
{
    //halaman form login 
    public function showLoginForm()
    {
        return view('auth.login_admin.index');
    }
    //memproses data dari form login
    public function login(Request $request)
    {
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);
    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }
    return back()->withErrors(['username'=> 'username atau password salah',])->onlyInput('username');

}
    public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
}
}
