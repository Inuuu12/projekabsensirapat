<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();

            // Batasi akun Dinas dan Kecamatan agar tidak bisa login ke portal Admin biasa (akan dikembangkan terpisah)
            if (in_array($user->role, ['dinas', 'kecamatan'])) {
                Auth::guard('admin')->logout();

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akun Dinas / Kecamatan tidak diizinkan login ke portal Admin Utama.',
                    ], 403);
                }

                return back()->withErrors([
                    'username' => 'Akun Dinas / Kecamatan tidak diizinkan masuk ke portal Admin Utama. Akses login khusus akan dikembangkan secara terpisah.',
                ])->onlyInput('username');
            }

            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'admin' => $user,
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Kredensial salah.'], 401);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Logout berhasil']);
        }

        return redirect()->route('admin.login')->with('status', 'Anda telah logout.');
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login_admin.index');
    }
}
