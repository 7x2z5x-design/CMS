<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Allowed roles for registration
    private const ALLOWED_ROLES = ['Author', 'Editor', 'Approver'];

    public function showRegisterForm()
    {
        return view('auth.register', ['roles' => self::ALLOWED_ROLES]);
    }

    public function register(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'Username' => 'required|string|max:50|unique:Users,Username',
            'Email' => 'required|string|email|max:100|unique:Users,Email',
            'password' => 'required|string|min:8|confirmed',
            'FullName' => 'required|string|max:100',
            'Bio' => 'nullable|string|max:5000',
            'ProfilePictureFile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ProfilePictureUrl' => 'nullable|url|max:255',
            'role' => 'required|string|in:' . implode(',', self::ALLOWED_ROLES),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $profilePicturePath = null;
            if ($request->hasFile('ProfilePictureFile')) {
                $file = $request->file('ProfilePictureFile');
                $filename = Str::slug($request->Username) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $profilePicturePath = $file->storeAs('profile-pictures', $filename, 'public');
            } elseif ($request->filled('ProfilePictureUrl')) {
                $profilePicturePath = $request->input('ProfilePictureUrl');
            }

            $role = $request->role;
            if (strtolower($role) === 'admin') {
                return redirect()->back()
                    ->withErrors(['role' => 'Admin role is not allowed during registration.'])
                    ->withInput();
            }

            User::create([
                'Username' => $request->Username,
                'Email' => $request->Email,
                'PasswordHash' => Hash::make($request->password),
                'FullName' => $request->FullName,
                'Bio' => $request->Bio,
                'ProfilePicture' => $profilePicturePath,
                'role' => $role,
            ]);

            return redirect('/login')->with('success', 'Registration successful! Please log in with your credentials.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred during registration. Please try again.'])
                ->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('Email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login successful.');
        }

        return back()->withErrors(['login' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}