<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalPosts = class_exists(\App\Models\Content::class) ? \App\Models\Content::count() : 0;
        
        // Dummy engagement logic
        $engagement = rand(60, 95) . '%';
        
        // Daily visits dummy data for chart
        $chartLabels = json_encode(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
        $chartData = json_encode([120, 190, 300, 250, 200, 320, 400]);

        return view('admin.analysis.index', compact(
            'totalUsers', 
            'totalCategories', 
            'totalPosts', 
            'engagement',
            'chartLabels',
            'chartData'
        ));
    }
}
