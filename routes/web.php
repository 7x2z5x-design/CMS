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
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorPostController;
use App\Http\Controllers\AuthorMediaController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ProfileController;

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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

// Redirect root to appropriate dashboard
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isEditor()) {
            return redirect()->route('editor.dashboard');
        } elseif (Auth::user()->isAuthor()) {
            return redirect()->route('author.dashboard');
        }
    }
    return redirect()->route('admin.dashboard');
});

// Author routes (protected by authentication and role)
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':Author'])->prefix('author')->name('author.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthorController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Author Posts
    Route::resource('posts', AuthorPostController::class);
    Route::get('/posts/{post}/analytics', [AuthorPostController::class, 'analytics'])->name('posts.analytics');
    
    // Author Media Library
    Route::get('/media', [AuthorMediaController::class, 'index'])->name('media.index');
    Route::delete('/media/{id}', [AuthorMediaController::class, 'destroy'])->name('media.destroy');
    
    // Author Revisions
    Route::get('/revisions/{id}', [AuthorPostController::class, 'showRevision'])->name('revisions.show');
    Route::get('/posts/{post}/revisions', [AuthorPostController::class, 'revisions'])->name('posts.revisions');
    Route::get('/posts/{post}/revisions/{revision}/compare', [AuthorPostController::class, 'compare'])->name('posts.revisions.compare');
    Route::post('/posts/{post}/restore/{revision}', [AuthorPostController::class, 'restoreRevision'])->name('posts.restore');
});

// Editor routes (protected by authentication and role)
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':Editor'])->prefix('editor')->name('editor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [EditorController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/preferences', [EditorController::class, 'preferences'])->name('preferences');
    
    // Content Management
    Route::resource('posts', EditorPostController::class);
    Route::resource('pages', EditorPageController::class);
    Route::resource('comments', EditorCommentController::class);
    Route::resource('media', EditorMediaController::class);
    
    // Editorial
    Route::resource('categories', EditorCategoryController::class);
    Route::resource('tags', EditorTagController::class);
    Route::get('/scheduled', [EditorController::class, 'scheduled'])->name('scheduled.index');
    Route::get('/drafts', [EditorController::class, 'drafts'])->name('drafts.index');
    
    // Review
    Route::get('/reviews', [EditorController::class, 'reviews'])->name('reviews.index');
    Route::get('/approved', [EditorController::class, 'approved'])->name('approved.index');
    Route::get('/rejected', [EditorController::class, 'rejected'])->name('rejected.index');
    
    // Analytics
    Route::get('/analytics', [EditorController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [EditorController::class, 'reports'])->name('reports.index');
    Route::get('/engagement', [EditorController::class, 'engagement'])->name('engagement.index');
    
    // SEO
    Route::get('/seo', [EditorController::class, 'seo'])->name('seo.index');
    Route::get('/keywords', [EditorController::class, 'keywords'])->name('keywords.index');
    
    // Tools
    Route::get('/import', [EditorController::class, 'import'])->name('import.index');
    Route::get('/export', [EditorController::class, 'export'])->name('export.index');
    Route::get('/backup', [EditorController::class, 'backup'])->name('backup.index');
});

// Public post display route
Route::get('/post/{slug}', [App\Http\Controllers\PublicPostController::class, 'show'])->name('public.post.show');

// Test view route
Route::get('/test-view', function () {
    return view('test');
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