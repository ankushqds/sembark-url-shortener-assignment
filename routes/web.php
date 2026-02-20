<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;


// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public URL redirection - NO AUTHENTICATION REQUIRED
Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('short.redirect');

// Guest Routes (only non-logged in users)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes (require login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard - accessible to all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // URL Management - accessible to all authenticated users but with role-based logic in controller
    Route::resource('urls', ShortUrlController::class)->except(['show', 'edit', 'update']);
    
    // Company Management - SUPER ADMIN ONLY
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('companies', CompanyController::class);
        // Additional company routes if needed
        Route::get('/companies/{company}/users', [CompanyController::class, 'users'])->name('companies.users');
    });
    
    // Invitation and User Management - SUPER ADMIN and ADMIN only
    Route::middleware('role:super_admin,admin')->group(function () {
        // Invitations
        Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
        
        // Users list (role-based filtering happens in controller)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        
        // Optional: View specific user details
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('can:view,user');
    });
});

// Fallback route for 404 
Route::fallback(function () {
    return view('errors.404');
});