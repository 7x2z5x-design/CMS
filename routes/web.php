<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\SystemController;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Admin routes (protected by authentication)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // Main dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management (Full CRUD)
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    
    // Multimedia Content Management
    Route::post('/content/{content}/approve', [App\Http\Controllers\ContentController::class, 'approve'])->name('content.approve');
    Route::post('/content/{content}/reject', [App\Http\Controllers\ContentController::class, 'reject'])->name('content.reject');
    Route::resource('content', App\Http\Controllers\ContentController::class);



    
    // Category Management
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::get('/categories/counts', [CategoryController::class, 'getCounts'])->name('categories.counts');
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::post('/categories/bulk-toggle-status', [CategoryController::class, 'bulkToggleStatus'])->name('categories.bulk-toggle-status');
    Route::post('/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::get('/categories/by-group/{group}', [CategoryController::class, 'getByGroup'])->name('categories.by-group');


    
    // Tag Management
    Route::resource('tags', TagController::class);


    
    // Media Management
    Route::resource('media', MediaController::class);


    
    // Analysis (Simple Dashboard Page)
    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');
    
    // System Control (Settings Page)
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/', [SystemController::class, 'index'])->name('index');
        Route::post('/roles/{user}', [SystemController::class, 'updateRole'])->name('roles.update');
        Route::post('/status/{user}', [SystemController::class, 'toggleUserStatus'])->name('status.toggle');
        Route::post('/settings', [SystemController::class, 'updateSettings'])->name('settings.update');
    });
});

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Database test route (keep for testing)
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Database connected successfully!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});