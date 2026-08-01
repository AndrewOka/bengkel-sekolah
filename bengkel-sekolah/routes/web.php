<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// --- ROUTE GUEST (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- ROUTE AUTHENTICATED (Sudah Login) ---
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Custom Route Status Booking
    Route::patch('/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // --- ROUTE TRASH (TEMPAT SAMPAH) BOOKING ---
    Route::get('/bookings/trash', [BookingController::class, 'trash'])->name('bookings.trash');
    Route::post('/bookings/{id}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
    Route::delete('/bookings/{id}/force-delete', [BookingController::class, 'forceDelete'])->name('bookings.forceDelete');

    // --- ROUTE TRASH (TEMPAT SAMPAH) CUSTOMER ---
    Route::get('/customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
    Route::post('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
    Route::delete('/customers/{id}/force-delete', [CustomerController::class, 'forceDelete'])->name('customers.forceDelete');

    // --- ROUTE TRASH (TEMPAT SAMPAH) VEHICLE ---
    Route::get('/vehicles/trash', [VehicleController::class, 'trash'])->name('vehicles.trash');
    Route::post('/vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
    Route::delete('/vehicles/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('vehicles.forceDelete');

    // --- ROUTE TRASH (TEMPAT SAMPAH) BRAND ---
    Route::get('/brands/trash', [BrandController::class, 'trash'])->name('brands.trash');
    Route::post('/brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('/brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');

    // CRUD Master Data & Booking
    Route::resource('bookings', BookingController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('users', RegisterController::class);
});