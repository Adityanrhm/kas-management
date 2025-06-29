<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        $route_pattern = [
            'user_id' => '[0-9]+'
        ];

        foreach ($route_pattern as $url => $regex) {
            Route::pattern($url, $regex);
        };
    }
}
