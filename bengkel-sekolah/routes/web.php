<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;

// --- ROUTE UNTUK GUEST (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- ROUTE UNTUK USER YANG SUDAH LOGIN ---
Route::middleware(['auth'])->group(function () {
    // Route Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Route Khusus Update Status Booking
    Route::patch('/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Route CRUD Master Data & Booking
    Route::resource('bookings', BookingController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('users', UserController::class);
});