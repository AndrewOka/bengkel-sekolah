<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'is_active' => true])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['username' => 'Username atau password salah / akun dinonaktifkan.']);
    }

    // Tampilkan Form Register
    public function showRegisterForm() {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    // Proses Simpan Register
    public function register(Request $request) {
        $request->validate([
            'username'  => 'required|string|max:255|unique:users,username',
            'full_name' => 'required|string|max:255',
            'password'  => 'required|string|min:6|confirmed',
            'role_id'   => 'required|exists:roles,role_id',
        ], [
            'username.unique'    => 'Username ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.'
        ]);

        $user = User::create([
            'username'  => $request->username,
            'full_name' => $request->full_name,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
            'is_active' => true,
        ]);

        // Otomatis Login setelah berhasil register
        Auth::login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang di Bengkel Sekolah.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}