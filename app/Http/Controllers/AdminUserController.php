<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required|string|max:50|unique:Users,Username',
            'Email' => 'required|email|unique:Users,Email',
            'PasswordHash' => 'required|string|min:6',
            'FullName' => 'nullable|string|max:100',
            'role' => 'required|in:Admin,Author,Editor',
        ]);

        User::create([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'PasswordHash' => Hash::make($request->PasswordHash),
            'FullName' => $request->FullName,
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'Username' => ['required', 'string', 'max:50', Rule::unique('Users', 'Username')->ignore($user->UserId, 'UserId')],
            'Email' => ['required', 'email', Rule::unique('Users', 'Email')->ignore($user->UserId, 'UserId')],
            'FullName' => 'nullable|string|max:100',
            'role' => 'required|in:Admin,Author,Editor',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'FullName' => $request->FullName,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User status updated.');
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:Admin,Author,Editor',
        ]);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User role updated.');
    }
}
