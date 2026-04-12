<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController; // 👈 NEW add
use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Post Routes (themed previews) ──
Route::middleware('auth')->group(function () {
    // Posts CRUD
    Route::get('/posts', function () {
        return view('posts.index');
    })->name('posts.index');

    Route::get('/posts/create', function () {
        return view('posts.create');
    })->name('posts.create');

    Route::post('/posts', function () {
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    })->name('posts.store');

    Route::get('/posts/{id}/edit', function ($id) {
        return view('posts.edit');
    })->name('posts.edit');

    Route::put('/posts/{id}', function ($id) {
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    })->name('posts.update');

    Route::delete('/posts/{id}', function ($id) {
        return redirect()->route('posts.index')->with('success', 'Post deleted.');
    })->name('posts.destroy');

    Route::get('/posts/review', function () {
        return view('posts.review');
    })->name('posts.review');
});
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ❌ OLD remove karo
// Route::get('/', function () {
//     return view('welcome');
// });


// 👇 isko rehne do (database test ke liye useful hai)
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Database connected successfully!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});