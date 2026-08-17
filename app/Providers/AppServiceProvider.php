<?php

namespace App\Providers;

use App\Models\Customer;
use Illuminate\Support\Facades\View;
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
        View::composer('layout.partials.sidebar', function ($view) {
            $todayRegistrations = Customer::whereDate('created_at', today())->count();

            $view->with('todayRegistrations', $todayRegistrations);
        });
    }
}
