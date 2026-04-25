<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    // Constructor removed to support Laravel 12. Middleware is handled in web.php.

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'Active')->count();
        $inactiveUsers = User::where('status', 'Inactive')->count();
        
        $recentUsers = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers', 
            'inactiveUsers',
            'recentUsers'
        ));
    }

    /**
     * Show the user management page.
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show content management page.
     */
    public function content()
    {
        return view('admin.content.index');
    }

    /**
     * Show category management page.
     */
    public function categories()
    {
        return view('admin.categories.index');
    }

    /**
     * Show tag management page.
     */
    public function tags()
    {
        return view('admin.tags.index');
    }

    /**
     * Show media management page.
     */
    public function media()
    {
        return view('admin.media.index');
    }

    /**
     * Show analysis page.
     */
    public function analysis()
    {
        return view('admin.analysis.index');
    }

    /**
     * Show system control page.
     */
    public function system()
    {
        return view('admin.system.index');
    }
}
