<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Import Model Role jika ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Form Register
    public function showRegisterForm()
    {
        // Jika ada model Role, ambil data role dari DB, atau passing manual
        $roles = Role::all(); 
        return view('auth.register', compact('roles'));
    }

    // Proses Registrasi
    public function register(Request $request)
    {
        // 1. Validasi Input (termasuk role_id)
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:6|confirmed',
            'role_id'   => 'required|integer', // Memastikan role dipilih
        ], [
            'username.unique'    => 'Username ini sudah terdaftar!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'password.min'       => 'Password minimal 6 karakter!',
            'role_id.required'   => 'Silakan pilih Role terlebih dahulu!',
        ]);

        // 2. Simpan Data ke Database
        User::create([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'password'  => Hash::make($request->password), // Di-hash demi keamanan
            'role_id'   => $request->role_id,              // Menyimpan role yang dipilih
            'is_active' => 1,
        ]);

        // 3. TANPA AUTO-LOGIN -> Langsung Lempar/Redirect ke Halaman Login
        return redirect()->route('login')->with('success', 'Registrasi akun berhasil! Silakan login.');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}