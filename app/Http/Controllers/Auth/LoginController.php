<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    // Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }
      // Proses Login
   public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    // Cari admin berdasarkan email
    $admin = Admin::where('email', $request->email)->first();

    // Validasi email
    if (!$admin) {
        return back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }

    // Cek status
    if (!$admin->status_aktif) {
        return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
    }

    // Cek password
    if (!Hash::check($request->password, $admin->passwordHash)) {
        return back()->withErrors(['password' => 'Password salah.']);
    }

    // Login
    Auth::login($admin);

    // Kirim popup
    session()->flash('login_success', 'Berhasil login! Selamat datang ' . $admin->namaAdmin);

    return redirect()->intended('/');
}


    // Logout
    public function logout()
    {
        Auth::logout();

        return redirect('/')
            ->with('logout_success', 'Berhasil logout!');
    }

}
