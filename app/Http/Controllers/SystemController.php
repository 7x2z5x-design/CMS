<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SystemController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized Access.');
        }

        $users = User::orderBy('name')->get();
        
        $logs = [];
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            $lines = file($logPath);
            $logs = array_slice(array_reverse($lines), 0, 20);
        }

        return view('admin.system.index', compact('users', 'logs'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }
        
        $request->validate(['role' => 'required|in:Admin,Editor,Viewer']);
        
        if (auth()->id() === $user->id && $request->role !== 'Admin') {
            return redirect()->back()->withErrors(['system' => 'You cannot change your own admin privileges.']);
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', "Role updated successfully for {$user->name}.");
    }

    public function toggleUserStatus(User $user)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }

        if (auth()->id() === $user->id) {
            return redirect()->back()->withErrors(['system' => 'You cannot disable your own account.']);
        }

        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return redirect()->back()->with('success', "Status updated successfully for {$user->name}.");
    }

    public function updateSettings(Request $request)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $request->validate([
            'site_name' => 'required|string|max:100',
            'contact_email' => 'required|email|max:100',
        ]);

        session(['site_name' => $request->site_name]);
        session(['contact_email' => $request->contact_email]);

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }
}
