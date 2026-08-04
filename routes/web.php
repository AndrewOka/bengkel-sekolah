<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;

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

    // Logout & Dashboard
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // --- FITUR KHUSUS STAFF & ADMIN (Ubah Status Booking) ---
    Route::patch('/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])
        ->middleware('can:update-booking-status')
        ->name('bookings.updateStatus');

    // --- FITUR KHUSUS MANAGER & ADMIN (Customer & Vehicle) ---
    Route::middleware('can:manage-master-data')->group(function () {
        // Customer CRUD & Trash
        Route::get('/customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
        Route::post('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
        Route::delete('/customers/{id}/force-delete', [CustomerController::class, 'forceDelete'])->name('customers.forceDelete');
        Route::resource('customers', CustomerController::class);

        // Vehicle CRUD & Trash
        Route::get('/vehicles/trash', [VehicleController::class, 'trash'])->name('vehicles.trash');
        Route::post('/vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
        Route::delete('/vehicles/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('vehicles.forceDelete');
        Route::resource('vehicles', VehicleController::class);
    });

    // --- FITUR KHUSUS ADMIN SAJA ---
    Route::middleware('can:isAdmin')->group(function () {
        // Brand
        Route::get('/brands/trash', [BrandController::class, 'trash'])->name('brands.trash');
        Route::post('/brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
        Route::delete('/brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
        Route::resource('brands', BrandController::class);

        // --- TRASH & MANAJEMEN USER ---
        Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
        
        // Menggunakan ->except(['create', 'store']) agar pembuatan user terfokus di menu Register
        Route::resource('users', UserController::class)->except(['create', 'store']);

        // Trash Booking
        Route::get('/bookings/trash', [BookingController::class, 'trash'])->name('bookings.trash');
        Route::post('/bookings/{id}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
        Route::delete('/bookings/{id}/force-delete', [BookingController::class, 'forceDelete'])->name('bookings.forceDelete');
    });

    // Route Booking Utama (List & Create)
    Route::resource('bookings', BookingController::class);
});