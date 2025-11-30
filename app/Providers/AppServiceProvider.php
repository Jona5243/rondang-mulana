<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

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
        // Mengirim data notifikasi ke view Header Admin setiap saat
        View::composer('layouts.admin.header', function ($view) {
            $notifications = collect();
            if (Auth::check()) {
                // Ambil notifikasi user yang sedang login
                $notifications = Auth::user()->unreadNotifications;
            }
            $view->with('notifications', $notifications);
        });
    }
}
