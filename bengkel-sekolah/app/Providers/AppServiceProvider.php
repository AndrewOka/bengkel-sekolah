<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate untuk Admin (Akses Penuh)
        Gate::define('isAdmin', function (User $user) {
            return optional($user->role)->role_name === 'Admin';
        });

        // Gate untuk Manager & Admin (Kelola Customer & Vehicle)
        Gate::define('manage-master-data', function (User $user) {
            return in_array(optional($user->role)->role_name, ['Admin', 'Manager']);
        });

        // Gate untuk Staff & Admin (Ubah Status Booking)
        Gate::define('update-booking-status', function (User $user) {
            return in_array(optional($user->role)->role_name, ['Admin', 'Staff']);
        });
    }
}