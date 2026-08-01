<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $users = User::with('role')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create() {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request) {
        $request->validate([
            'username'  => 'required|unique:users,username',
            'password'  => 'required|min:6',
            'full_name' => 'required|string|max:255',
            'role_id'   => 'required|exists:roles,role_id',
        ]);

        User::create([
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'full_name' => $request->full_name,
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('users.index')->with('success', 'User bengkel berhasil ditambahkan.');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $request->validate([
            'username'  => 'required|unique:users,username,'.$id.',user_id',
            'full_name' => 'required|string|max:255',
            'role_id'   => 'required|exists:roles,role_id',
        ]);

        $data = [
            'username'  => $request->username,
            'full_name' => $request->full_name,
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($id) {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}