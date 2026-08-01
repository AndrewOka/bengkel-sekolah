<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        $users = User::with('role')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:6',
            'role_id'   => 'required|exists:roles,role_id',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username,' . $id . ',user_id',
            'role_id'   => 'required|exists:roles,role_id',
        ]);

        $data = [
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Soft delete user (Pindah ke Trash)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dipindahkan ke tempat sampah!');
    }

    /**
     * Menampilkan daftar user yang ada di Trash
     */
    public function trash()
    {
        $users = User::onlyTrashed()->with('role')->paginate(10);
        return view('users.trash', compact('users'));
    }

    /**
     * Restore user dari Trash
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->where('user_id', $id)->firstOrFail();
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'User berhasil dikembalikan!');
    }

    /**
     * Hapus permanen user
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->where('user_id', $id)->firstOrFail();
        $user->forceDelete();

        return redirect()->route('users.trash')->with('success', 'User berhasil dihapus secara permanen!');
    }
}