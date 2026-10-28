<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk admin (memerlukan login + role admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::patch('/admin/users/{user}/role', [AdminDashboardController::class, 'updateRole'])
        ->name('admin.users.update-role');
    Route::delete('/admin/users/{user}', [AdminDashboardController::class, 'destroy'])
        ->name('admin.users.destroy');
});

// Route untuk user biasa (memerlukan login)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard');
    })->name('user.dashboard');
    
    // Profile routes
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])
        ->name('profile.update');
    Route::patch('/profile/password', [UserProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

require __DIR__ . '/auth.php';
