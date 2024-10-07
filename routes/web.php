<?php

use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController; // Add this line
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return redirect('login');
});

// Updated Dashboard Route
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard'); // Ensure you have a Dashboard view
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Group for Authenticated Users
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/user', UserController::class)->except('create', 'show', 'edit');
    Route::post('/user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');
    
    Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');

    Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');
});

// New route for login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Optional route for login page
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

// Other Routes
Route::get('/form', function () {
    return Inertia::render('SakaiForm');
});

Route::get('/button', function () {
    return Inertia::render('SakaiButton');
});

Route::get('/list', function () {
    return Inertia::render('SakaiList');
});

require __DIR__.'/auth.php';
